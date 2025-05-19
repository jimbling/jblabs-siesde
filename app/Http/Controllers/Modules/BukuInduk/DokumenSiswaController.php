<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StudentDocument;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class DokumenSiswaController extends Controller
{
    // Simpan dokumen baru
    public function store(Request $request, Student $student)
    {

        $request->validate([
            'tipe_dokumen' => 'required|in:kk,akta_kelahiran,surat_pindah,ijazah_tk,ijazah_sd,lainnya',
            'file' => 'required|image|mimes:jpg,jpeg,png|max:150', // ukuran dalam KB
            'keterangan' => 'nullable|string|max:255'
        ]);

        // Cek duplikat dokumen untuk siswa
        $exists = $student->dokumen()
            ->where('tipe_dokumen', $request->tipe_dokumen)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Dokumen dengan tipe ini sudah pernah diupload.'
            ], 422); // status 422: Unprocessable Entity (validasi)
        }

        $file = $request->file('file');
        $fileName = Str::slug($student->nama) . '_' . $request->tipe_dokumen . '_' . time() . '.webp';
        $directory = 'doc_siswa/' . $student->id;
        $fullPath = storage_path('app/public/' . $directory);

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        // Gunakan ImageManager untuk konversi webp
        $imageManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $webpImage = $imageManager->read($file)->toWebp(85);
        Storage::disk('public')->put($directory . '/' . $fileName, (string) $webpImage);

        // Simpan ke database
        $student->dokumen()->create([
            'tipe_dokumen' => $request->tipe_dokumen,
            'path_file' => $directory . '/' . $fileName,
            'keterangan' => $request->keterangan,
            'tanggal_upload' => now()
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diupload.');
    }


    // Hapus dokumen
    public function destroy($id)
    {
        try {
            $document = StudentDocument::findOrFail($id);

            // Hapus file fisik
            if ($document->path_file && Storage::disk('public')->exists($document->path_file)) {
                Storage::disk('public')->delete($document->path_file);
            }

            // Hapus record database
            $document->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Delete document error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus dokumen'
            ], 500);
        }
    }

    public function partial($studentId)
    {
        $student = Student::with('dokumen')->findOrFail($studentId);

        return view('modules.students.partials.student-documents', compact('student'));
    }
}
