<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\UserGoogleDriveToken;
use Google_Client;
use Google_Service_Oauth2;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        $formatTokenArray = function ($tokenData) {
            $expiresIn = now()->diffInSeconds($tokenData->token_expires_at);
            return [
                'access_token' => $tokenData->access_token,
                'refresh_token' => $tokenData->refresh_token,
                'expires_in' => max($expiresIn, 0),
                'created' => now()->subSeconds($expiresIn)->timestamp,
            ];
        };

        if (Session::has('pending_google_token')) {
            $token = Session::pull('pending_google_token');
            $googleUser = Session::pull('pending_google_user_info');

            UserGoogleDriveToken::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'access_token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'] ?? null,
                    'token_expires_at' => now()->addSeconds($token['expires_in'] ?? 3600),
                    'connected_at' => now(),
                    'name' => $googleUser['name'] ?? null,
                    'email' => $googleUser['email'] ?? null,
                    'picture' => $googleUser['picture'] ?? null,
                ]
            );

            session([
                'google_access_token' => $token,
                'google_drive_user' => $googleUser,
            ]);
        } else {
            $tokenData = UserGoogleDriveToken::where('user_id', $user->id)->first();

            if ($tokenData && $tokenData->token_expires_at && $tokenData->token_expires_at->isFuture()) {

                session(['google_access_token' => $formatTokenArray($tokenData)]);
            } elseif ($tokenData && $tokenData->refresh_token) {
                $client = new Google_Client();
                $client->setClientId(env('GOOGLE_CLIENT_ID'));
                $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
                $client->setAccessToken($formatTokenArray($tokenData));

                $newTokenRaw = $client->fetchAccessTokenWithRefreshToken($tokenData->refresh_token);

                if (isset($newTokenRaw['access_token'])) {
                    $expiresIn = $newTokenRaw['expires_in'] ?? 3600;
                    $refreshToken = $newTokenRaw['refresh_token'] ?? $tokenData->refresh_token;

                    UserGoogleDriveToken::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'access_token' => $newTokenRaw['access_token'],
                            'refresh_token' => $refreshToken,
                            'token_expires_at' => now()->addSeconds($expiresIn),
                            'connected_at' => now(),
                            // Jangan update name/email/picture di sini karena tidak tersedia
                        ]
                    );

                    session(['google_access_token' => [
                        'access_token' => $newTokenRaw['access_token'],
                        'refresh_token' => $refreshToken,
                        'expires_in' => $expiresIn,
                        'created' => now()->timestamp,
                    ]]);
                } else {
                    session()->forget(['google_access_token', 'google_drive_user']);
                }
            } else {
                session()->forget(['google_access_token', 'google_drive_user']);
            }

            if (Session::has('google_access_token') && !Session::has('google_drive_user')) {
                try {
                    $client = new Google_Client();
                    $client->setAccessToken(Session::get('google_access_token'));

                    $oauth2 = new Google_Service_Oauth2($client);
                    $googleUser = $oauth2->userinfo->get();

                    session(['google_drive_user' => [
                        'id' => $googleUser->id,
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'picture' => $googleUser->picture,
                    ]]);
                } catch (\Exception $e) {
                    session()->forget(['google_access_token', 'google_drive_user']);
                }
            }
        }


        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
