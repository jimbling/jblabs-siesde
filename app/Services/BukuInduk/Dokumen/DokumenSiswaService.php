<?php

namespace App\Services\BukuInduk\Dokumen;

use App\Models\Student;
use App\Models\StudentDocument;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class DokumenSiswaService
{
    public function store($request, Student $student)
    {
        $request->validate([
            'tipe_dokumen' => 'required|in:kk,akta_kelahiran,surat_pindah,ijazah_tk,ijazah_sd,lainnya',
            'file' => 'required|image|mimes:jpg,jpeg,png|max:150',
            'keterangan' => 'nullable|string|max:255'
        ]);

        if ($student->dokumen()->where('tipe_dokumen', $request->tipe_dokumen)->exists()) {
            return response()->json([
                'message' => 'Dokumen dengan tipe ini sudah pernah diupload.'
            ], 422);
        }

        return $this->saveDocument($request, $student);
    }

    private function saveDocument($request, Student $student)
    {
        $file = $request->file('file');
        $fileName = Str::slug($student->nama) . '_' . $request->tipe_dokumen . '_' . time() . '.webp';
        $directory = 'doc_siswa/' . $student->id;
        $fullPath = storage_path('app/public/' . $directory);

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }


        $imageManager = new ImageManager(new Driver());
        $webpImage = $imageManager->read($file)->toWebp(85);
        Storage::disk('public')->put($directory . '/' . $fileName, (string) $webpImage);


        return $student->dokumen()->create([
            'tipe_dokumen' => $request->tipe_dokumen,
            'path_file' => $directory . '/' . $fileName,
            'keterangan' => $request->keterangan,
            'tanggal_upload' => now()
        ]);
    }

    public function destroy($id)
    {
        try {
            $document = StudentDocument::findOrFail($id);

            if ($document->path_file && Storage::disk('public')->exists($document->path_file)) {
                Storage::disk('public')->delete($document->path_file);
            }

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

    public function getStudentDocuments($studentId)
    {
        return Student::with('dokumen')->findOrFail($studentId);
    }
}
