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
        $students = Student::whereHas('statusTerakhir', function ($query) {
            $query->where('status', 'aktif');
        })->orderBy('nipd', 'asc')->get();

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

        // Ambil data referensi untuk form edit
        $agamaList = Agama::pluck('nama', 'id'); // [id => nama]
        $jenisTinggalList = JenisTinggal::pluck('nama', 'id');
        $alatTransportasiList = AlatTransportasi::pluck('nama', 'id');
        $pendidikans = Pendidikan::pluck('jenjang', 'id'); // [id => jenjang]
        $pekerjaans = Pekerjaan::pluck('nama', 'id');      // [id => nama]
        $penghasilans = Penghasilan::pluck('rentang', 'id'); // [id => rentang]

        return view('modules.buku-induk.detail-siswa', [
            'title' => 'Detail Siswa',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Data Siswa', 'url' => route('induk.siswa')],
                ['name' => 'Detail Siswa'],
            ]),
            'student' => $student,
            'riwayatSekolah' => $riwayatSekolah,
            'riwayatRombel' => $riwayatRombel,

            // Kirim ke view
            'agamaList' => $agamaList,
            'jenisTinggalList' => $jenisTinggalList,
            'alatTransportasiList' => $alatTransportasiList,

            'pendidikans' => $pendidikans,
            'pekerjaans' => $pekerjaans,
            'penghasilans' => $penghasilans,
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


    public function updateBiodata(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nik' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'agama_id' => 'nullable|exists:agama,id',
            'telepon' => 'nullable|string|max:20',
            'hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'dusun' => 'nullable|string|max:100',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'jenis_tinggal_id' => 'nullable|exists:jenis_tinggal,id',
            'alat_transportasi_id' => 'nullable|exists:alat_transportasi,id',
        ]);

        $student->update($validated);

        return redirect()
            ->to(route('induk.siswa.show', $student->uuid) . '#tabs-biodata')
            ->with('success', 'Biodata berhasil diperbarui.');
    }

    public function updateOrtu(Request $request, Student $student)
    {
        foreach (['ayah', 'ibu'] as $tipe) {
            $data = $request->input($tipe);
            if (!$data) continue;

            $student->orangTuas()->updateOrCreate(
                ['id' => $data['id'] ?? null],
                [
                    'tipe' => $tipe,
                    'nama' => $data['nama'],
                    'tahun_lahir' => $data['tahun_lahir'],
                    'nik' => $data['nik'],
                    'pendidikan_id' => $data['pendidikan_id'] ?? null,
                    'pekerjaan_id' => $data['pekerjaan_id'] ?? null,
                    'penghasilan_id' => $data['penghasilan_id'] ?? null,
                ]
            );
        }

        return redirect()
            ->to(route('induk.siswa.show', $student->uuid) . '#tabs-ortu')
            ->with('success', 'Data orang tua berhasil diperbarui.');
    }

    public function updateLokasi(Request $request, Student $student)
    {
        $validated = $request->validate([
            'jarak_rumah_km' => 'nullable|numeric',
            'lintang' => 'nullable|string|max:50',
            'bujur' => 'nullable|string|max:50',
            'bank' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:50',
            'rekening_atas_nama' => 'nullable|string|max:255',
        ]);

        $student->update($validated);

        return redirect()
            ->to(route('induk.siswa.show', $student->uuid) . '#tabs-lokasi') // kalau mau redirect ke show, gunakan route show
            ->with('success', 'Data lokasi dan bank berhasil diperbarui.');
    }

    public function updateSosial(Request $request, Student $student)
    {
        $validated = $request->validate([
            'penerima_kps' => 'nullable|boolean',
            'no_kps' => 'nullable|string|max:100',
            'penerima_kip' => 'nullable|boolean',
            'nomor_kip' => 'nullable|string|max:100',
            'nama_di_kip' => 'nullable|string|max:255',
            'nomor_kks' => 'nullable|string|max:100',
            'layak_pip' => 'nullable|boolean',
            'alasan_layak_pip' => 'nullable|string|max:255',
        ]);

        // Convert checkbox to boolean
        $validated['penerima_kps'] = $request->has('penerima_kps');
        $validated['penerima_kip'] = $request->has('penerima_kip');
        $validated['layak_pip'] = $request->has('layak_pip');

        $student->update($validated);

        return redirect()
            ->route('induk.siswa.show', $student->uuid)
            ->with('success', 'Data sosial berhasil diperbarui.')
            ->withFragment('tabs-sosial');
    }
}
