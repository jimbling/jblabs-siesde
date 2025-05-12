<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use App\Models\Student;
use App\Models\DocumentLog;
use App\Helpers\BreadcrumbHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Mpdf\Mpdf;

class BindukController extends Controller
{
    // Fungsi untuk menampilkan daftar siswa dan filter
    public function index(Request $request)
    {
        // Filter untuk menampilkan siswa yang belum memiliki nomor dokumen
        $students = Student::when($request->has('filter') && $request->filter === 'no_nomor_dokumen', function ($query) {
            return $query->whereNull('nomor_dokumen');
        })->get();

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
    public function generatePDF($uuid)
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

        // Debug untuk melihat data siswa beserta relasinya
        dd($student);

        $riwayatSekolah = $student->riwayatSekolah->first();
        $riwayatRombel = $student->studentRombels;

        // Membuat PDF menggunakan DOMPDF
        $pdf = Mpdf::loadView('modules.buku-induk.pdf', [
            'student' => $student,
            'riwayatSekolah' => $riwayatSekolah,
            'riwayatRombel' => $riwayatRombel,
        ]);

        // Menyimpan atau mengirimkan PDF ke browser
        return $pdf->download('Buku_Induk_' . $student->nomor_dokumen . '.pdf');
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

        // Ambil data riwayat sekolah dan rombel
        $riwayatSekolah = $student->riwayatSekolah;
        $riwayatRombel = $student->studentRombels;

        // Tampilkan halaman detail siswa
        return view('modules.buku-induk.binduk-detail-siswa', compact('student', 'riwayatSekolah', 'riwayatRombel'));
    }


    // Fungsi untuk verifikasi dokumen dan menyimpan log verifikasi
    public function verifikasiDokumen(Request $request, $uuid)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        $student = Student::where('uuid', $uuid)->firstOrFail();

        // Catat log verifikasi
        DocumentLog::create([
            'uuid' => Str::uuid(),
            'student_id' => $student->id,
            'jenis_dokumen' => 'buku_induk',
            'nomor_dokumen' => $student->nomor_dokumen,
            'dicetak_oleh' => auth()->id(),
            'waktu_cetak' => now(),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('binduk.index')->with('success', 'Dokumen telah berhasil diverifikasi.');
    }
}
