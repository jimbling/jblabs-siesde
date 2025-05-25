<?php

namespace App\Services\Pengaturan\Gdrive;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\UserGoogleDriveToken;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Client;


class GoogleDriveService
{
    public function getUserGoogleDriveSession()
    {
        $user = Auth::user();

        $googleUser = session('google_drive_user');
        $googleToken = session('google_access_token');

        if (!$googleUser || !$googleToken) {
            $tokenModel = UserGoogleDriveToken::where('user_id', $user->id)->first();

            if ($tokenModel && $tokenModel->token_expires_at > now()) {
                session([
                    'google_access_token' => $tokenModel->getTokenArray(),
                    'google_drive_user' => [
                        'name' => $user->name,
                        'email' => $tokenModel->email,
                        'picture' => $tokenModel->picture,
                    ],
                ]);

                $googleUser = session('google_drive_user');
                $googleToken = session('google_access_token');
            }
        }

        return [
            'googleUser' => $googleUser,
            'googleToken' => $googleToken,
        ];
    }

    public function handleCallback(array $user, array $token)
    {
        if (!empty($user['picture'])) {
            try {
                $response = Http::timeout(5)->get($user['picture']);
                if ($response->ok()) {
                    $filename = 'avatars/avatar_' . uniqid() . '.jpg';
                    Storage::disk('public')->put($filename, $response->body());
                    $user['picture'] = asset('storage/' . $filename);
                }
            } catch (\Exception $e) {
                // log or ignore
            }
        }

        Session::put('google_drive_user', $user);
        Session::put('google_access_token', $token);

        if (Auth::check()) {
            UserGoogleDriveToken::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'access_token' => $token['access_token'],
                    'refresh_token' => $token['refresh_token'] ?? null,
                    'token_expires_at' => now()->addSeconds($token['expires_in'] ?? 3600),
                    'connected_at' => now(),
                    'name' => $user['name'] ?? null,
                    'email' => $user['email'] ?? null,
                    'picture' => $user['picture'] ?? null,
                ]
            );

            return ['redirect' => route('google.drive.index'), 'status' => 'success'];
        }

        Session::put('pending_google_token', $token);
        Session::put('pending_google_user_info', $user);
        return ['redirect' => route('login'), 'status' => 'pending'];
    }

    public function storeOrUpdateToken($userId, array $token, array $user)
    {
        \App\Models\UserGoogleDriveToken::updateOrCreate(
            ['user_id' => $userId],
            [
                'access_token' => $token['access_token'],
                'refresh_token' => $token['refresh_token'] ?? null,
                'token_expires_at' => now()->addSeconds($token['expires_in'] ?? 3600),
                'connected_at' => now(),
                'name' => $user['name'] ?? null,
                'email' => $user['email'] ?? null,
                'picture' => $user['picture'] ?? null,
            ]
        );
    }

    public function getOrCreateFolder(Drive $service, string $folderName, ?string $parentId = null): string
    {
        $query = "mimeType = 'application/vnd.google-apps.folder' and name = '$folderName' and trashed = false";
        if ($parentId) {
            $query .= " and '$parentId' in parents";
        }

        $results = $service->files->listFiles(['q' => $query]);
        if (count($results->getFiles()) > 0) {
            return $results->getFiles()[0]->getId();
        }

        $fileMetadata = new DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder',
        ]);

        if ($parentId) {
            $fileMetadata->setParents([$parentId]);
        }

        $folder = $service->files->create($fileMetadata, ['fields' => 'id']);
        return $folder->id;
    }

    public function getAuthorizedDriveService(): ?Drive
    {
        $googleToken = UserGoogleDriveToken::where('user_id', auth()->id())->first();
        if (!$googleToken) return null;

        $client = new Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setAccessToken($googleToken->getTokenArray());

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                $newToken = $client->getAccessToken();
                $googleToken->update([
                    'access_token' => $newToken['access_token'],
                    'token_expires_at' => now()->addSeconds($newToken['expires_in']),
                ]);
            } else {
                return null;
            }
        }

        return new Drive($client);
    }

    public function deleteFile(string $fileId): bool
    {
        $service = $this->getAuthorizedDriveService();
        if (!$service) {
            throw new \Exception('Google Drive tidak terhubung atau token tidak valid.');
        }

        try {
            $service->files->delete($fileId);
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Gagal menghapus file dari Google Drive: ' . $e->getMessage());
        }
    }

    public function revokeAccess(): bool
    {
        $accessToken = Session::get('google_access_token');
        if (!$accessToken) {
            return false;
        }

        $client = new \Google\Client();
        $client->setAccessToken($accessToken);
        $revoked = $client->revokeToken();

        // Clear session
        Session::forget('google_access_token');
        Session::forget('google_drive_user');
        Session::save();

        // Clear DB token
        $user = Auth::user();
        UserGoogleDriveToken::where('user_id', $user->id)->update([
            'access_token' => null,
            'refresh_token' => null,
            'token_expires_at' => null,
            'connected_at' => null,
            'revoked_at' => now(),
        ]);

        return $revoked;
    }
}
