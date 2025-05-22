<?php

namespace App\Services\BukuInduk;

use Mpdf\Mpdf;
use App\Models\Student;
use App\Models\DocumentLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

class GeneratePDFService
{
    public function generate($studentUuid)
    {
        $student = Student::where('uuid', $studentUuid)->firstOrFail();

        // Cek apakah ada log dokumen lama yang masih valid, jika ada ubah statusnya
        $existingLog = DocumentLog::where('student_id', $student->id)
            ->where('jenis', 'generate_pdf')
            ->where('is_valid', true)
            ->first();

        if ($existingLog) {
            $existingLog->update(['is_valid' => false]);
        }

        // Buat kode verifikasi unik
        $shortCode = Str::random(8);

        // Simpan log dokumen baru
        DocumentLog::create([
            'uuid' => Str::uuid(),
            'short_code' => $shortCode,
            'student_id' => $student->id,
            'user_id' => auth()->id(),
            'jenis' => 'generate_pdf',
            'keterangan' => 'Generate PDF Buku Induk',
            'is_valid' => true,
            'jenis_dokumen' => 'Buku Induk',
            'nomor_dokumen' => $student->nomor_dokumen,
            'dicetak_oleh' => auth()->id(),
            'waktu_cetak' => now(),
        ]);

        // Ambil data terkait siswa
        $riwayatSekolah = $student->riwayatSekolah;
        $riwayatRombel = $student->studentRombels;
        $fotoSiswa = $student->fotoSiswa()->with('tahunPelajaran')->orderByDesc('created_at')->take(3)->get();

        // Generate QR Code
        $qrUrl = route('short.dokumen.verifikasi', ['shortCode' => $shortCode]);
        $qrDataUri = $this->generateQrCode($qrUrl);

        // Generate PDF
        return $this->generatePdfFile($student, $riwayatSekolah, $riwayatRombel, $fotoSiswa, $qrDataUri);
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

    private function generatePdfFile($student, $riwayatSekolah, $riwayatRombel, $fotoSiswa, $qrDataUri)
    {
        $namaSekolah = system_setting('nama_sekolah', 'Nama Sekolah');
        $npsn = system_setting('npsn', 'NPSN');
        $logoFullPath = public_path('storage/' . system_setting('logo'));

        // Render HTML untuk PDF
        $html = view('modules.buku-induk.binduk-pdf', compact(
            'student',
            'riwayatSekolah',
            'riwayatRombel',
            'fotoSiswa',
            'qrDataUri'
        ))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'pdfa' => true,
            'pdfaauto' => true,
        ]);

        $mpdf->SetTitle('Buku Induk');
        $mpdf->SetAuthor($namaSekolah);
        $mpdf->SetCreator($namaSekolah);
        $mpdf->SetProtection(['print']);

        // Tambahkan watermark jika ada logo sekolah
        if (file_exists($logoFullPath)) {
            $mpdf->SetWatermarkImage($logoFullPath, 0.1, [100, 100], '', false);
            $mpdf->showWatermarkImage = true;
        } else {
            $mpdf->SetWatermarkText($namaSekolah, 0.1);
            $mpdf->showWatermarkText = true;
        }

        // Tambahkan footer pada PDF
        $mpdf->SetHTMLFooter('
        <div style="border-top:1px solid #ccc; padding-top:4px;">
            <table width="100%" style="font-size:10px; font-family: sans-serif;">
                <tr>
                    <td width="50%" align="left">Buku Induk - ' . $namaSekolah . ' | NPSN: ' . $npsn . '</td>
                    <td width="50%" align="right">Halaman {PAGENO} dari {nbpg}</td>
                </tr>
            </table>
        </div>
        ');

        try {
            $mpdf->WriteHTML($html);
            return $mpdf->Output('Buku_Induk_' . $student->nama . '.pdf', 'D');
        } catch (\Exception $e) {
            Log::error('Error generating PDF for UUID: ' . $student->uuid . ' - ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat membuat PDF.');
        }
    }
}
