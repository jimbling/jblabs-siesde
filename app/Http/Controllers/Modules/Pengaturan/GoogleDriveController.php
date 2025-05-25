<?php

namespace App\Http\Controllers\Modules\Pengaturan;

use App\Models\Student;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Models\StudentRaporFile;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Pengaturan\Gdrive\GoogleDriveService;


class GoogleDriveController extends Controller
{
    protected $gdriveService;

    public function __construct(GoogleDriveService $gdriveService)
    {
        $this->gdriveService = $gdriveService;
    }

    public function index()
    {
        $user = Auth::user();
        $googleData = $this->gdriveService->getUserGoogleDriveSession();

        return view('modules.admin.pengaturan-gdrive', [
            'title' => 'Pengaturan Google Drive',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Pengaturan Google Drive']
            ]),
            'user' => $user,
            'googleUser' => $googleData['googleUser'],
            'googleToken' => $googleData['googleToken'],
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
        $result = $this->gdriveService->handleCallback($user, $token);

        if ($result['status'] === 'success') {
            return redirect($result['redirect'])->with('success', 'Google Drive berhasil terhubung!');
        }

        return redirect($result['redirect'])->with('info', 'Silakan login untuk menyelesaikan koneksi Google Drive.');
    }


    public function uploadRapor(Request $request, $uuid)
    {
        $student = Student::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'document' => 'required|file|max:10240',
            'semester_id' => 'required|exists:semester,id',
            'nama_file' => 'required|string|max:255',
        ]);

        $service = $this->gdriveService->getAuthorizedDriveService();

        if (!$service) {
            return redirect()->route('google.drive.index')->with('error', 'Google Drive belum terhubung atau token tidak valid.');
        }

        // Buat folder Scan Nilai Rapot / {uuid}
        $parentFolderId = $this->gdriveService->getOrCreateFolder($service, 'Scan Nilai Rapot');
        $studentFolderId = $this->gdriveService->getOrCreateFolder($service, $student->uuid, $parentFolderId);

        // Upload file ke Google Drive
        $file = new \Google\Service\Drive\DriveFile();
        $file->setName($request->file('document')->getClientOriginalName());
        $file->setParents([$studentFolderId]);

        $uploadedFile = $service->files->create($file, [
            'data' => file_get_contents($request->file('document')->getPathname()),
            'mimeType' => $request->file('document')->getMimeType(),
            'uploadType' => 'multipart'
        ]);

        $semester = Semester::with('tahunPelajaran')->findOrFail($request->semester_id);

        StudentRaporFile::create([
            'student_uuid'       => $student->uuid,
            'tahun_pelajaran_id' => $semester->tahun_pelajaran_id,
            'semester_id'        => $semester->id,
            'nama_file'          => $request->input('nama_file'),
            'file_id_drive'      => $uploadedFile->id,
            'mime_type'          => $request->file('document')->getMimeType(),
            'drive_url'          => 'https://drive.google.com/file/d/' . $uploadedFile->id . '/view',
        ]);

        return back()->with('success', 'File rapor berhasil diunggah dan disimpan ke database!');
    }

    public function destroy($id)
    {
        $file = StudentRaporFile::findOrFail($id);

        try {
            $this->gdriveService->deleteFile($file->file_id_drive);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
        $revoked = $this->gdriveService->revokeAccess();

        if ($revoked) {
            return redirect()->route('google.drive.index')->with('success', 'Akses Google Drive berhasil dicabut.');
        } else {
            return redirect()->route('google.drive.index')->with('error', 'Gagal mencabut akses Google. Token mungkin sudah tidak valid.');
        }
    }
}
