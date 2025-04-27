<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use App\Helpers\BreadcrumbHelper;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index()
    {

        $students = Student::all();

        return view('modules.buku-induk.data-siswa', [
            'title' => 'Data Siswa',
            'breadcrumbs' => BreadcrumbHelper::generate([['name' => 'Data Siswa']]),
            'students' => $students,
            'totalStudents' => $students->count(),
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new StudentsImport, $request->file('file'));
            return redirect()->route('induk.siswa')->with('success', 'Data siswa berhasil diimpor')->withInput([]);
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($uuid)
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
        ])->where('uuid', $uuid)->firstOrFail();

        $riwayatSekolah = $student->riwayatSekolah->first();
        $riwayatRombel = $student->studentRombels;

        Log::info('Student Rombels: ', $student->studentRombels->toArray());

        return view('modules.buku-induk.detail-siswa', [
            'title' => 'Detail Siswa',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Data Siswa', 'url' => route('induk.siswa')],
                ['name' => 'Detail Siswa'],
            ]),
            'student' => $student,
            'riwayatSekolah' => $riwayatSekolah,
            'riwayatRombel' => $riwayatRombel,

        ]);
    }
}
