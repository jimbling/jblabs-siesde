<?php

namespace App\Traits;

use App\Models\DocumentLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait LogsDocument
{
    public function logDocument($studentId, array $data)
    {
        // Cek apakah sudah ada log yang valid untuk jenis dokumen ini
        $existingLog = DocumentLog::where('student_id', $studentId)
            ->where('jenis', $data['jenis'])
            ->where('is_valid', true)
            ->first();

        if ($existingLog) {
            // Jika sudah ada log valid, tidak perlu buat log baru
            return $existingLog;
        }

        // Tandai semua log lama dari jenis ini sebagai tidak valid
        DocumentLog::where('student_id', $studentId)
            ->where('jenis', $data['jenis'])
            ->update(['is_valid' => false]);

        // Buat log baru dengan langsung is_valid = 1
        return DocumentLog::create([
            'uuid'           => Str::uuid(),
            'student_id'     => $studentId,
            'jenis_dokumen'  => $data['jenis_dokumen'] ?? 'Buku Induk',
            'nomor_dokumen'  => $data['nomor_dokumen'] ?? null,
            'dicetak_oleh'   => Auth::id(),
            'waktu_cetak'    => now(),
            'keterangan'     => $data['keterangan'] ?? null,
            'is_valid'       => true,
            'jenis'          => $data['jenis'],
        ]);
    }
}
