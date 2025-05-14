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
use Maatwebsite\Excel\Facades\Excel;

class BindukController extends Controller
{
    // Fungsi untuk menampilkan daftar siswa dan filter
    public function index(Request $request)
    {
        // Filter untuk menampilkan siswa yang belum memiliki nomor dokumen
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
                // Jika siswa sudah memiliki nomor dokumen, tambahkan nama ke array
                $existingStudents[] = $student->nama;
            } else {
                // Jika belum ada nomor dokumen, generate nomor dokumen baru
                do {
                    $generatedNumber = 'BINDUK-' . $tahun . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
                } while (Student::where('nomor_dokumen', $generatedNumber)->exists());

                $student->nomor_dokumen = $generatedNumber;
                $student->save();
            }
        }

        // Jika ada siswa yang sudah memiliki nomor dokumen, beri pesan kustom
        if (count($existingStudents) > 0) {
            return redirect()->route('induk.index')->with('error', 'Siswa ' . implode(', ', $existingStudents) . ' sudah memiliki nomor dokumen.');
        }

        return redirect()->route('induk.index')->with('success', 'Nomor dokumen berhasil digenerate untuk siswa yang dipilih.');
    }




    // Fungsi untuk generate PDF Buku Induk
    public function generatePDF($studentUuid)
    {
        $student = Student::where('uuid', $studentUuid)->firstOrFail();

        // Cek apakah sudah ada log yang valid untuk student_id dan jenis 'generate_pdf'
        $existingLog = DocumentLog::where('student_id', $student->id)
            ->where('jenis', 'generate_pdf')
            ->where('is_valid', true)
            ->first();

        if ($existingLog) {
            // Jika log valid sudah ada, perbarui log lama dan set is_valid = 0 untuk yang lama
            $existingLog->update(['is_valid' => false]);
        }

        // Persiapkan data PDF
        $riwayatSekolah = $student->riwayatSekolah;
        $riwayatRombel = $student->studentRombels;
        $fotoSiswa = $student->fotoSiswa()->with('tahunPelajaran')->orderByDesc('created_at')->take(3)->get();
        $qrUrl = route('induk.dokumen.verifikasi', ['uuid' => Str::uuid()]);

        $html = view('modules.buku-induk.binduk-pdf', compact('student', 'riwayatSekolah', 'riwayatRombel', 'fotoSiswa', 'qrUrl'))->render();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
        ]);

        $mpdf->SetWatermarkText('DOKUMEN RESMI', 0.1);
        $mpdf->showWatermarkText = true;

        $mpdf->SetHTMLFooter('
        <div style="border-top:1px solid #ccc; padding-top:4px;">
            <table width="100%" style="font-size:10px; font-family: sans-serif;">
                <tr>
                    <td width="50%" align="left">Buku Induk - SD Negeri Kedungrejo</td>
                    <td width="50%" align="right">Halaman {PAGENO} dari {nbpg}</td>
                </tr>
            </table>
        </div>
        ');

        try {
            // Generate PDF
            $mpdf->WriteHTML($html);

            // Simpan log setelah PDF berhasil dihasilkan
            $log = DocumentLog::create([
                'uuid' => Str::uuid(),
                'student_id' => $student->id,
                'user_id' => auth()->id(),
                'jenis' => 'generate_pdf',
                'keterangan' => 'Generate PDF Buku Induk',
                'is_valid' => true,
                'jenis_dokumen' => 'Buku Induk',
                'nomor_dokumen'  => $student->nomor_dokumen,
                'dicetak_oleh'   => Auth::id(),
                'waktu_cetak'    => now(),
            ]);

            // Log info
            Log::info('GENERATE PDF CALLED for UUID: ' . $studentUuid);

            // Output PDF
            return $mpdf->Output('Buku_Induk_' . $student->nama . '.pdf', 'D');
        } catch (\Exception $e) {
            // Jika terjadi error saat generate PDF, rollback atau lakukan penanganan error
            Log::error('Error generating PDF for UUID: ' . $studentUuid . ' - ' . $e->getMessage());
            // Anda bisa menambahkan penanganan error di sini
        }
    }


    public function showStudentDetail($uuid)
    {
        // Ambil data siswa berdasarkan UUID
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
        ])->where('uuid', $uuid)->firstOrFail();

        // Ambil maksimal 6 foto dari relasi foto_siswa
        $fotoSiswa = $student->fotoSiswa()->with('tahunPelajaran')->orderByDesc('created_at')->take(3)->get();

        // Ambil data riwayat
        $riwayatSekolah = $student->riwayatSekolah;
        $riwayatRombel = $student->studentRombels;

        // Ambil data log dokumen berdasarkan uuid
        $log = DocumentLog::where('student_id', $student->id)->first();  // Gantilah dengan log yang relevan jika berbeda query

        // Set judul halaman dengan nama siswa
        $title = 'Detail Siswa - ' . $student->nama;

        // Tampilkan halaman detail siswa
        return view('modules.buku-induk.binduk-detail-siswa', compact('student', 'riwayatSekolah', 'riwayatRombel', 'fotoSiswa', 'title', 'log'));
    }




    public function cetak(Request $request)
    {
        $student = Student::findOrFail($request->student_id);

        // Tandai log sebelumnya sebagai tidak valid (jika ingin hanya 1 log aktif per siswa & jenis)
        DocumentLog::where('student_id', $student->id)
            ->where('jenis', 'print_view')
            ->update(['is_valid' => false]);

        $log = DocumentLog::create([
            'student_id'     => $student->id,
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

        // Menambahkan URL untuk QR code (misalnya, URL untuk verifikasi dokumen)
        $qrUrl = route('induk.dokumen.verifikasi', ['uuid' => $log->uuid]);

        return view('modules.buku-induk.binduk-print', compact('student', 'log', 'riwayatSekolah', 'riwayatRombel', 'fotoSiswa', 'qrUrl'));
    }


    // Fungsi untuk verifikasi dokumen dan menyimpan log verifikasi
    public function verifikasiDokumen($uuid)
    {
        try {
            // Ambil data DocumentLog berdasarkan uuid, termasuk data siswa
            $log = DocumentLog::with('student')->where('uuid', $uuid)->firstOrFail();

            $student = $log->student;

            return view('modules.buku-induk.binduk-verifikasi', compact('student', 'log'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Tampilkan halaman khusus jika UUID tidak ditemukan
            return response()->view('modules.errors.verifikasi-tidak-ditemukan', [
                'title' => 'Dokumen Tidak Ditemukan',
            ], 404);
        }
    }
}
