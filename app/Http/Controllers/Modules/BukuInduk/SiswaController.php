<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use Str;
use App\Models\Agama;
use App\Models\Student;
use App\Models\OrangTua;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
use App\Models\JenisTinggal;
use Illuminate\Http\Request;
use App\Models\RiwayatSekolah;
use App\Imports\StudentsImport;
use App\Models\KebutuhanKhusus;
use App\Models\AlatTransportasi;
use App\Services\StudentService;
use App\Helpers\BreadcrumbHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StudentStoreRequest;

class SiswaController extends Controller
{
    public function index()
    {
        $students = Student::all();
        $agamas = Agama::all();
        $alatTransportasis = AlatTransportasi::all();
        $jenisTinggals = JenisTinggal::all();
        $kebutuhanKhususes = KebutuhanKhusus::all();

        // Tambahan untuk dropdown orang tua
        $pekerjaans = Pekerjaan::all();
        $pendidikans = Pendidikan::all();
        $penghasilans = Penghasilan::all();

        return view('modules.buku-induk.data-siswa', [
            'title' => 'Data Siswa',
            'breadcrumbs' => BreadcrumbHelper::generate([['name' => 'Data Siswa']]),
            'students' => $students,
            'totalStudents' => $students->count(),
            'agamas' => $agamas,
            'alatTransportasis' => $alatTransportasis,
            'jenisTinggals' => $jenisTinggals,
            'kebutuhanKhususes' => $kebutuhanKhususes,
            'pekerjaans' => $pekerjaans,
            'pendidikans' => $pendidikans,
            'penghasilans' => $penghasilans,
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
            'fotoTerbaru',
        ])->where('uuid', $uuid)->firstOrFail();

        $riwayatSekolah = $student->riwayatSekolah;
        $riwayatRombel = $student->studentRombels;

        // Log::info('Student Rombels: ', $student->studentRombels->toArray());

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

    public function addSiswa()
    {


        $students = Student::all();
        $agamas = Agama::all();
        $alatTransportasis = AlatTransportasi::all();
        $jenisTinggals = JenisTinggal::all();
        $kebutuhanKhususes = KebutuhanKhusus::all();

        return view('modules.buku-induk.data-siswa', [
            'title' => 'Tambah Data Siswa',
            'breadcrumbs' => BreadcrumbHelper::generate([['name' => 'Tambah Baru']]),
            'students' => $students,
            'totalStudents' => $students->count(),
            'agamas' => $agamas,
            'alatTransportasis' => $alatTransportasis,
            'jenisTinggals' => $jenisTinggals,
            'kebutuhanKhususes' => $kebutuhanKhususes,
        ]);
    }


    public function store(StudentStoreRequest $request, StudentService $studentService)
    {
        try {
            $studentService->store($request->validated());

            return redirect()->route('induk.siswa')->with('success', 'Data siswa berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }
}
