<?php

namespace App\Services\BukuInduk;

use App\Models\Student;
use App\Models\DocumentLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

class CetakService
{
    public function cetak($studentId)
    {
        $student = Student::findOrFail($studentId);

        // Update status dokumen sebelumnya jadi tidak valid
        DocumentLog::where('student_id', $student->id)
            ->where('jenis', 'print_view')
            ->update(['is_valid' => false]);

        // Simpan log cetak baru
        $log = DocumentLog::create([
            'student_id'     => $student->id,
            'short_code' => Str::random(8),
            'jenis_dokumen'  => 'Buku Induk',
            'nomor_dokumen'  => $student->nomor_dokumen,
            'dicetak_oleh'   => Auth::id(),
            'waktu_cetak'    => now(),
            'keterangan'     => 'Cetak Buku Induk dari halaman detail siswa',
            'is_valid'       => true,
            'jenis'          => 'print_view',
        ]);

        return $log->uuid; // Kirim UUID untuk halaman cetak
    }

    public function getPrintData($uuid)
    {
        $log = DocumentLog::with(['student', 'user'])->where('uuid', $uuid)->firstOrFail();
        $student = Student::with([
            'agama',
            'alatTransportasi',
            'jenisTinggal',
            'orangTuas.pendidikan',
            'orangTuas.pekerjaan',
            'orangTuas.penghasilan',
            'riwayatSekolah',
            'studentRombels.tahunPelajaran',
            'studentRombels.semester',
            'studentRombels.rombel',
            'fotoTerbaru',
        ])->findOrFail($log->student_id);

        return [
            'student' => $student,
            'log' => $log,
            'riwayatSekolah' => $student->riwayatSekolah,
            'riwayatRombel' => $student->studentRombels,
            'fotoSiswa' => $student->fotoSiswa()->with('tahunPelajaran')->orderByDesc('created_at')->take(3)->get(),
            'qrUrl' => route('short.dokumen.verifikasi', ['shortCode' => $log->short_code]),
            'qrDataUri' => $this->generateQrCode(route('short.dokumen.verifikasi', ['shortCode' => $log->short_code])),
        ];
    }

    private function generateQrCode($qrUrl)
    {
        $logoPath = public_path('storage/' . system_setting('qrcode_logo'));

        $builder = new Builder(
            writer: new PngWriter(),
            validateResult: false,
            data: $qrUrl,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            logoPath: $logoPath,
            logoResizeToWidth: 120,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255),
        );

        return $builder->build()->getDataUri();
    }
}
