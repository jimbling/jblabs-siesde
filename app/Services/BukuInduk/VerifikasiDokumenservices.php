<?php

namespace App\Services\BukuInduk;

use App\Models\DocumentLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VerifikasiDokumenServices
{
    public function getVerificationByUuid($uuid)
    {
        try {
            $log = DocumentLog::with('student')->where('uuid', $uuid)->firstOrFail();
            return [
                'student' => $log->student,
                'log' => $log,
            ];
        } catch (ModelNotFoundException $e) {
            return ['error' => 'Dokumen Tidak Ditemukan'];
        }
    }

    public function getVerificationByShortCode($shortCode)
    {
        try {
            $log = DocumentLog::with('student')->where('short_code', $shortCode)->firstOrFail();
            return [
                'student' => $log->student,
                'log' => $log,
            ];
        } catch (ModelNotFoundException $e) {
            return ['error' => 'Dokumen Tidak Ditemukan'];
        }
    }
}
