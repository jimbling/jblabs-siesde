<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use Mpdf\Mpdf;
use App\Models\Student;
use App\Models\DocumentLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;





class BindukController extends Controller
{
    // Fungsi untuk menampilkan daftar siswa dan filter
    public function index(Request $request)
    {

        $students = Student::when($request->has('filter') && $request->filter === 'no_nomor_dokumen', function ($query) {
            return $query->whereNull('nomor_dokumen');
        })->get();

        // Tentukan apakah siswa sudah memiliki nomor dokumen
        foreach ($students as $student) {
            $student->can_generate_pdf = !is_null($student->nomor_dokumen);
        }

        return view('modules.buku-induk.binduk-index', [
            'title' => 'Data Siswa Buku Induk',
            'breadcrumbs' => BreadcrumbHelper::generate([['name' => 'Data Siswa Buku Induk']]),
            'students' => $students,
            'totalStudents' => $students->count(),
        ]);
    }


    // Fungsi untuk generate nomor dokumen untuk siswa yang dipilih
    public function generateNomorDokumen(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ], [
            'student_ids.required' => 'Silakan pilih minimal satu siswa untuk generate nomor dokumen.',
            'student_ids.array' => 'Data siswa yang dipilih tidak valid. Silakan pilih siswa dengan benar.',
            'student_ids.*.exists' => 'Beberapa siswa yang Anda pilih tidak ditemukan dalam sistem.',
        ]);

        $students = Student::whereIn('id', $request->student_ids)->get();
        $tahun = date('Y');
        $existingStudents = [];

        foreach ($students as $student) {
            if ($student->nomor_dokumen) {

                $existingStudents[] = $student->nama;
            } else {

                do {
                    $generatedNumber = 'BINDUK-' . $tahun . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
                } while (Student::where('nomor_dokumen', $generatedNumber)->exists());

                $student->nomor_dokumen = $generatedNumber;
                $student->save();
            }
        }

        if (count($existingStudents) > 0) {
            return redirect()->route('induk.index')->with('error', 'Peserta Didik ' . implode(', ', $existingStudents) . ' sudah memiliki nomor dokumen.');
        }

        return redirect()->route('induk.index')->with('success', 'Nomor dokumen berhasil digenerate untuk siswa yang dipilih.');
    }





    // Fungsi untuk generate PDF Buku Induk
    public function generatePDF($studentUuid)
    {
        $student = Student::where('uuid', $studentUuid)->firstOrFail();


        $existingLog = DocumentLog::where('student_id', $student->id)
            ->where('jenis', 'generate_pdf')
            ->where('is_valid', true)
            ->first();

        if ($existingLog) {
            $existingLog->update(['is_valid' => false]);
        }

        $shortCode = Str::random(8);

        $log = DocumentLog::create([
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

        $riwayatSekolah = $student->riwayatSekolah;
        $riwayatRombel = $student->studentRombels;
        $fotoSiswa = $student->fotoSiswa()->with('tahunPelajaran')->orderByDesc('created_at')->take(3)->get();

        $qrUrl = route('short.dokumen.verifikasi', ['shortCode' => $shortCode]);

        $logoPath = public_path('storage/' . system_setting('qrcode_logo'));

        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $qrUrl,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            logoPath: $logoPath,
            logoResizeToWidth: 120,
            logoPunchoutBackground: false,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255),
        );


        $result = $builder->build();
        $qrDataUri = $result->getDataUri();

        $namaSekolah = system_setting('nama_sekolah', 'Nama Sekolah');
        $npsn = system_setting('npsn', 'NPSN');
        $logoFullPath = public_path('storage/' . system_setting('logo'));

        $html = view('modules.buku-induk.binduk-pdf', compact(
            'student',
            'riwayatSekolah',
            'riwayatRombel',
            'fotoSiswa',
            'qrDataUri'
        ))->render();


        $mpdf = new \Mpdf\Mpdf([
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


        if (file_exists($logoFullPath)) {
            $mpdf->SetWatermarkImage($logoFullPath, 0.1, [100, 100], '', false);
            $mpdf->showWatermarkImage = true;
        } else {
            $mpdf->SetWatermarkText($namaSekolah, 0.1);
            $mpdf->showWatermarkText = true;
        }


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
            Log::error('Error generating PDF for UUID: ' . $studentUuid . ' - ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat membuat PDF.');
        }
    }





    public function showStudentDetail($uuid)
    {
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
            'dokumen' // Tambahkan eager loading untuk dokumen
        ])->where('uuid', $uuid)->firstOrFail();

        $student->can_generate_pdf = !is_null($student->nomor_dokumen);

        $fotoSiswa = $student->fotoSiswa()->with('tahunPelajaran')->orderByDesc('created_at')->take(3)->get();
        $riwayatSekolah = $student->riwayatSekolah;
        $riwayatRombel = $student->studentRombels;
        $log = DocumentLog::where('student_id', $student->id)->first();

        $title = 'Detail Siswa - ' . $student->nama;

        return view('modules.buku-induk.binduk-detail-siswa', compact(
            'student',
            'riwayatSekolah',
            'riwayatRombel',
            'fotoSiswa',
            'title',
            'log'
        ));
    }





    public function cetak(Request $request)
    {
        $student = Student::findOrFail($request->student_id);


        DocumentLog::where('student_id', $student->id)
            ->where('jenis', 'print_view')
            ->update(['is_valid' => false]);

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

        return redirect()->route('induk.buku-induk.print', $log->uuid);
    }


    public function print($uuid)
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

        $riwayatSekolah = $student->riwayatSekolah;
        $riwayatRombel = $student->studentRombels;
        $fotoSiswa = $student->fotoSiswa()->with('tahunPelajaran')->orderByDesc('created_at')->take(3)->get();

        $qrUrl = route('short.dokumen.verifikasi', ['shortCode' => $log->short_code]);


        $logoPath = public_path('storage/' . system_setting('qrcode_logo'));


        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $qrUrl,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            logoPath: $logoPath,
            logoResizeToWidth: 120,
            logoPunchoutBackground: false,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255),
        );

        $result = $builder->build();
        $qrDataUri = $result->getDataUri();

        return view('modules.buku-induk.binduk-print', compact(
            'student',
            'log',
            'riwayatSekolah',
            'riwayatRombel',
            'fotoSiswa',
            'qrUrl',
            'qrDataUri'
        ));
    }



    public function verifikasiDokumen($uuid)
    {
        try {

            $log = DocumentLog::with('student')->where('uuid', $uuid)->firstOrFail();

            $student = $log->student;

            return view('modules.buku-induk.binduk-verifikasi', compact('student', 'log'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return response()->view('modules.errors.verifikasi-tidak-ditemukan', [
                'title' => 'Dokumen Tidak Ditemukan',
            ], 404);
        }
    }

    public function verifikasiDokumenShort($shortCode)
    {
        try {
            $log = DocumentLog::with('student')->where('short_code', $shortCode)->firstOrFail();
            $student = $log->student;

            return view('modules.buku-induk.binduk-verifikasi', compact('student', 'log'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->view('modules.errors.verifikasi-tidak-ditemukan', [
                'title' => 'Dokumen Tidak Ditemukan',
            ], 404);
        }
    }
}
