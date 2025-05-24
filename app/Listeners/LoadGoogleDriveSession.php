<?php

namespace App\Listeners;

use Google_Client;
use Google\Service\Oauth2;
use Google_Service_Oauth2;
use Illuminate\Auth\Events\Login;
use App\Models\UserGoogleDriveToken;
use Illuminate\Support\Facades\Session;

class LoadGoogleDriveSession
{
    public function handle(Login $event)
    {
        $user = $event->user;

        $tokenData = UserGoogleDriveToken::where('user_id', $user->id)->first();
        if (!$tokenData) return;

        // Jika token masih berlaku
        if ($tokenData->token_expires_at && $tokenData->token_expires_at->isFuture()) {
            Session::put('google_access_token', $tokenData->access_token);
        } elseif ($tokenData->refresh_token) {
            // Refresh token jika perlu
            $client = new Google_Client();
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setAccessToken($tokenData->access_token);

            $newToken = $client->fetchAccessTokenWithRefreshToken($tokenData->refresh_token);
            if (isset($newToken['access_token'])) {
                $tokenData->update([
                    'access_token' => $newToken['access_token'],
                    'refresh_token' => $newToken['refresh_token'] ?? $tokenData->refresh_token,
                    'token_expires_at' => now()->addSeconds($newToken['expires_in'] ?? 3600),
                    'connected_at' => now(),
                ]);

                Session::put('google_access_token', $newToken['access_token']);
            }
        }

        // Set google_drive_user juga ke session
        if (Session::has('google_access_token')) {
            try {
                $client = new Google_Client();
                $client->setAccessToken(Session::get('google_access_token'));

                $oauth2 = new Google_Service_Oauth2($client);
                $googleUser = $oauth2->userinfo->get();

                Session::put('google_drive_user', [
                    'id' => $googleUser->id,
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'picture' => $googleUser->picture,
                ]);
            } catch (\Exception $e) {
                Session::forget('google_access_token');
                Session::forget('google_drive_user');
            }
        }
    }
}
