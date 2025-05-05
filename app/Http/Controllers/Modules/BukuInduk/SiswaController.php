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
        ], [
            'file.required' => 'Silakan unggah file Excel terlebih dahulu.',
            'file.mimes'    => 'Format file tidak valid. Harus berupa file dengan ekstensi .xlsx atau .xls.',
        ]);

        try {
            $importer = new StudentsImport;
            Excel::import($importer, $request->file('file'));

            // Cek apakah ada error dari proses import
            if ($importer->hasErrors()) {
                return back()->with('import_error_file', session('import_error_file'));
            }

            return redirect()->route('induk.siswa')->with('success', 'Data siswa berhasil diimpor');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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

    public function destroy($uuid)
    {
        $student = Student::where('uuid', $uuid)->firstOrFail();
        $student->delete();

        return back()->with('success', 'Siswa berhasil dihapus.');
    }


    public function massDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        Student::whereIn('id', $ids)->delete();

        return redirect()->route('induk.siswa')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
