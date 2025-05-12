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
use App\Helpers\BreadcrumbHelper;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StudentStoreRequest;
use Illuminate\Support\Facades\DB;

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


    public function store(StudentStoreRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // Create and save new student
                $student = new Student();
                $student->fill($request->all());
                $student->save();

                // Simpan data orang tua
                $orangTuas = [];
                if ($request->filled('ayah_nama')) {
                    $orangTuas[] = [
                        'siswa_uuid'     => $student->uuid,
                        'tipe'           => 'ayah',
                        'nama'           => $request->input('ayah_nama'),
                        'tahun_lahir'    => $request->input('ayah_tahun_lahir'),
                        'pendidikan_id'  => $request->input('ayah_pendidikan_id'),
                        'pekerjaan_id'   => $request->input('ayah_pekerjaan_id'),
                        'penghasilan_id' => $request->input('ayah_penghasilan_id'),
                        'nik'            => $request->input('ayah_nik'),
                        'kewarganegaraan' => $request->input('ayah_kewarganegaraan'), // Tambahkan jika ada di form
                    ];
                }
                if ($request->filled('ibu_nama')) {
                    $orangTuas[] = [
                        'siswa_uuid'     => $student->uuid,
                        'tipe'           => 'ibu',
                        'nama'           => $request->input('ibu_nama'),
                        'tahun_lahir'    => $request->input('ibu_tahun_lahir'),
                        'pendidikan_id'  => $request->input('ibu_pendidikan_id'),
                        'pekerjaan_id'   => $request->input('ibu_pekerjaan_id'),
                        'penghasilan_id' => $request->input('ibu_penghasilan_id'),
                        'nik'            => $request->input('ibu_nik'),
                        'kewarganegaraan' => $request->input('ibu_kewarganegaraan'), // Tambahkan jika ada di form
                    ];
                }
                if ($request->filled('wali_nama')) {
                    $orangTuas[] = [
                        'siswa_uuid'     => $student->uuid,
                        'tipe'           => 'wali',
                        'nama'           => $request->input('wali_nama'),
                        'tahun_lahir'    => $request->input('wali_tahun_lahir'),
                        'pendidikan_id'  => $request->input('wali_pendidikan_id'),
                        'pekerjaan_id'   => $request->input('wali_pekerjaan_id'),
                        'penghasilan_id' => $request->input('wali_penghasilan_id'),
                        'nik'            => $request->input('wali_nik'),
                        'kewarganegaraan' => $request->input('wali_kewarganegaraan'), // Tambahkan jika ada di form
                    ];
                }

                // Simpan data orang tua menggunakan create() untuk mengaktifkan timestamps
                foreach ($orangTuas as $orangTuaData) {
                    OrangTua::create($orangTuaData);
                }

                // Simpan data riwayat sekolah
                $riwayatSekolah = new RiwayatSekolah([
                    'siswa_uuid'       => $student->uuid,
                    'jenis_pendaftar'  => $request->input('jenis_pendaftar'),
                    'sekolah_asal'     => $request->input('sekolah_asal'),
                    'dari_sekolah'     => $request->input('dari_sekolah'),
                    'alasan_pindah'    => $request->input('alasan_pindah'),
                    'catatan_kembali'  => $request->input('catatan_kembali'),
                    'lama_belajar'     => $request->input('lama_belajar'),
                    'nomor_ijazah'     => $request->input('nomor_ijazah'),
                    'tanggal_ijazah'   => $request->filled('tanggal_ijazah') ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('tanggal_ijazah'))->toDateString() : null,
                    'skhun'            => $request->input('skhun'),
                    'tanggal_masuk'    => now()->toDateString(),
                    'kelas_diterima'   => $request->input('kelas_diterima'),
                ]);
                $riwayatSekolah->save();

                // Update student dengan riwayat_sekolah_id
                $student->riwayat_sekolah_id = $riwayatSekolah->id;
                $student->save();
            });

            return redirect()->route('induk.siswa')->with('success', 'Data siswa berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }
}
