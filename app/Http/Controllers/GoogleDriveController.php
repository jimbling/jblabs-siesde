<?php

namespace App\Http\Controllers;

use Google\Client;
use App\Models\Student;
use App\Models\Semester;
use Google\Service\Drive;
use Illuminate\Http\Request;
use App\Models\StudentRaporFile;
use App\Helpers\BreadcrumbHelper;
use Illuminate\Routing\Controller;
use Google\Service\Drive\DriveFile;
use App\Models\UserGoogleDriveToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $googleUser = session('google_drive_user');
        $googleToken = session('google_access_token');

        // dd([
        //     'googleUser' => $googleUser,
        //     'googleToken' => $googleToken,
        //     'all_session' => session()->all(),
        // ]);
        if (!$googleUser || !$googleToken) {
            $tokenModel = UserGoogleDriveToken::where('user_id', $user->id)->first();

            if ($tokenModel && $tokenModel->token_expires_at > now()) {
                session([
                    'google_access_token' => $tokenModel->getTokenArray(),
                    'google_drive_user' => [
                        'name' => $user->name,
                        // Jika kamu menyimpan email, foto, dll Google profile di DB, ambil di sini juga
                        'email' => $tokenModel->email,
                        'picture' => $tokenModel->picture,
                    ],
                ]);

                $googleUser = session('google_drive_user');
                $googleToken = session('google_access_token');
            }
        }

        return view('google_drive_upload', [
            'title' => 'Pengaturan Google Drive',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Dashboard', 'url' => route('dashboard')],
                ['name' => 'Pengaturan Google Drive']
            ]),
            'user' => $user,
            'googleUser' => $googleUser,
            'googleToken' => $googleToken,
        ]);
    }




    public function handleCallback(Request $request)
    {
        $user = [
            'id' => $request->get('id'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'picture' => $request->get('picture'),
        ];
        $token = json_decode($request->get('token'), true);

        if (!empty($user['picture'])) {
            try {
                $response = Http::timeout(5)->get($user['picture']);
                if ($response->ok()) {
                    $filename = 'avatars/avatar_' . uniqid() . '.jpg';
                    Storage::disk('public')->put($filename, $response->body());
                    $user['picture'] = asset('storage/' . $filename);
                }
            } catch (\Exception $e) {
            }
        }

        Session::put('google_drive_user', $user);
        Session::put('google_access_token', $token);

        if (Auth::check()) {
            UserGoogleDriveToken::updateOrCreate(
                ['user_id' => Auth::id()], // <- gunakan internal user id, integer
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
            return redirect()->route('google.drive.index')->with('success', 'Google Drive berhasil terhubung!');
        }

        Session::put('pending_google_token', $token);
        Session::put('pending_google_user_info', $user);
        return redirect()->route('login')->with('info', 'Silakan login untuk menyelesaikan koneksi Google Drive.');
    }



    private function getOrCreateFolder(Drive $service, $folderName, $parentId = null)
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


    public function uploadRapor(Request $request, $uuid)
    {
        $student = Student::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'document' => 'required|file|max:10240',
            'semester_id' => 'required|exists:semester,id',
            'nama_file' => 'required|string|max:255',
        ]);

        $googleToken = UserGoogleDriveToken::where('user_id', auth()->id())->first();
        if (!$googleToken) {
            return redirect()->route('google.drive.index')->with('error', 'Google Drive belum terhubung!');
        }

        $client = new Client();
        $client->setAuthConfig(storage_path('credentials/credentials.json'));
        $client->setAccessToken($googleToken->getTokenArray());

        // Refresh token jika expired
        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

                $newToken = $client->getAccessToken();
                $googleToken->update([
                    'access_token' => $newToken['access_token'],
                    'token_expires_at' => now()->addSeconds($newToken['expires_in']),
                ]);
            } else {
                return redirect()->route('google.drive.index')->with('error', 'Token expired dan tidak bisa diperbarui. Silakan login ulang.');
            }
        }

        $service = new Drive($client);

        // Buat folder jika belum ada
        $parentFolderId = $this->getOrCreateFolder($service, 'Scan Nilai Rapot');
        $studentFolderId = $this->getOrCreateFolder($service, $student->uuid, $parentFolderId);

        // Upload file
        $file = new DriveFile();
        $file->setName($request->file('document')->getClientOriginalName());
        $file->setParents([$studentFolderId]);

        $content = file_get_contents($request->file('document')->getPathname());

        $uploadedFile = $service->files->create($file, [
            'data' => $content,
            'mimeType' => $request->file('document')->getMimeType(),
            'uploadType' => 'multipart'
        ]);

        $semester = Semester::with('tahunPelajaran')->findOrFail($request->semester_id);

        StudentRaporFile::create([
            'student_uuid'       => $student->uuid,
            'tahun_pelajaran_id' => $semester->tahun_pelajaran_id,
            'semester_id'        => $semester->id,
            'nama_file'          => $request->input('nama_file'), // manual name
            'file_id_drive'      => $uploadedFile->id,
            'mime_type'          => $request->file('document')->getMimeType(),
            'drive_url'          => 'https://drive.google.com/file/d/' . $uploadedFile->id . '/view',
        ]);

        return back()->with('success', 'File rapor berhasil diunggah dan disimpan ke database!');
    }


    public function destroy($id)
    {
        $file = StudentRaporFile::findOrFail($id);

        $googleToken = UserGoogleDriveToken::where('user_id', auth()->id())->first();
        if (!$googleToken) {
            return response()->json([
                'success' => false,
                'message' => 'Google Drive belum terhubung!'
            ], 400);
        }

        $client = new Client();
        $client->setAuthConfig(storage_path('credentials/credentials.json'));
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
                return response()->json([
                    'success' => false,
                    'message' => 'Token Google Drive kedaluwarsa dan tidak dapat diperbarui.'
                ], 400);
            }
        }

        $service = new Drive($client);

        try {
            $service->files->delete($file->file_id_drive);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus file dari Google Drive: ' . $e->getMessage()
            ], 500);
        }

        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'File rapor berhasil dihapus.'
        ]);
    }



    public function revokeAccess(Request $request)
    {
        $accessToken = Session::get('google_access_token');

        if (!$accessToken) {
            return redirect()->back()->with('error', 'Tidak ada koneksi Google yang aktif.');
        }

        $client = new \Google\Client();
        $client->setAccessToken($accessToken);
        $revoked = $client->revokeToken();

        // Hapus dari session
        Session::forget('google_access_token');
        Session::forget('google_drive_user');
        Session::save();

        // Kosongkan token di database, tanpa menghapus record
        $user = Auth::user();
        UserGoogleDriveToken::where('user_id', $user->id)->update([
            'access_token' => null,
            'refresh_token' => null,
            'token_expires_at' => null,
            'connected_at' => null,
            'revoked_at' => now(), // pastikan kolom ini ada di migration
        ]);

        if ($revoked) {
            return redirect()->route('google.drive.index')->with('success', 'Akses Google Drive berhasil dicabut.');
        } else {
            return redirect()->route('google.drive.index')->with('error', 'Gagal mencabut akses Google. Token mungkin sudah tidak valid.');
        }
    }

    // public function uploadFile(Request $request)
    // {
    //     $client = new Client();
    //     $client->setAuthConfig(storage_path('credentials/credentials.json'));
    //     $token = Session::get('google_access_token');

    //     if (!$token) {
    //         return redirect()->route('google.drive.index')->with('error', 'Please login first.');
    //     }

    //     $client->setAccessToken($token);

    //     $client->setAccessToken($token);

    //     if ($client->isAccessTokenExpired()) {
    //         $refreshToken = $client->getRefreshToken();

    //         if ($refreshToken) {
    //             $newToken = $client->fetchAccessTokenWithRefreshToken($refreshToken);
    //             if (!isset($newToken['refresh_token'])) {
    //                 $newToken['refresh_token'] = $refreshToken;
    //             }
    //             Session::put('google_access_token', $newToken);
    //             $client->setAccessToken($newToken);
    //         } else {
    //             Session::forget('google_access_token');
    //             Session::forget('google_drive_user');
    //             return redirect()->route('google.drive.redirect')->with('error', 'Session expired, please login again.');
    //         }
    //     }

    //     $service = new Drive($client);

    //     $folderId = $this->getOrCreateFolder($service, 'Scan Nilai Rapot');

    //     $file = new DriveFile();
    //     $file->setName($request->file('document')->getClientOriginalName());
    //     $file->setParents([$folderId]);

    //     $content = file_get_contents($request->file('document')->getPathname());

    //     $uploadedFile = $service->files->create($file, [
    //         'data' => $content,
    //         'mimeType' => $request->file('document')->getMimeType(),
    //         'uploadType' => 'multipart'
    //     ]);

    //     return redirect()->route('google.drive.upload')->with('success', 'File uploaded to folder! ID: ' . $uploadedFile->id);
    // }
}
