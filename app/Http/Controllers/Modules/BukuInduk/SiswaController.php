<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use App\Models\Student;
use App\Helpers\BreadcrumbHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentStoreRequest;
use App\Services\BukuInduk\PesertaDidik\ImportService;
use App\Services\BukuInduk\PesertaDidik\StudentService;
use App\Services\BukuInduk\PesertaDidik\SimpanStudentService;
use App\Services\BukuInduk\PesertaDidik\ReferenceDataService;
use App\Services\BukuInduk\PesertaDidik\StudentUpdateService;
use App\Services\BukuInduk\PesertaDidik\StudentDataService;


class SiswaController extends Controller
{
    protected $studentService;
    protected $referenceDataService;
    protected $importService;
    protected $studentUpdateService;
    protected $studentDataService;
    protected $simpanstudentService;

    public function __construct(
        StudentService $studentService,
        ReferenceDataService $referenceDataService,
        ImportService $importService,
        StudentUpdateService $studentUpdateService,
        StudentDataService $studentDataService,
        SimpanStudentService $simpanstudentService
    ) {
        $this->studentService = $studentService;
        $this->referenceDataService = $referenceDataService;
        $this->importService = $importService;
        $this->studentUpdateService = $studentUpdateService;
        $this->studentDataService = $studentDataService;
        $this->simpanstudentService = $simpanstudentService;
    }

    public function index()
    {
        $students = $this->studentService->getActiveStudents();
        $references = $this->referenceDataService->getAllReferences();

        return view('modules.buku-induk.data-siswa', array_merge([
            'title' => 'Data Siswa',
            'breadcrumbs' => BreadcrumbHelper::generate([['name' => 'Data Siswa']]),
            'students' => $students,
            'totalStudents' => $students->count(),
        ], $references));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ], [
            'file.required' => 'Silakan unggah file Excel terlebih dahulu.',
            'file.mimes' => 'Format file tidak valid. Harus berupa file dengan ekstensi .xlsx atau .xls.',
        ]);

        try {
            $this->importService->importStudents($request->file('file'));
            return redirect()->route('induk.siswa')->with('success', 'Data siswa berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($uuid)
    {
        $student = $this->studentService->getStudentDetails($uuid);
        $references = $this->referenceDataService->getAllReferences();

        return view('modules.buku-induk.detail-siswa', array_merge([
            'title' => 'Detail Siswa',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Data Siswa', 'url' => route('induk.siswa')],
                ['name' => 'Detail Siswa'],
            ]),
            'student' => $student,
            'riwayatSekolah' => $student->riwayatSekolah,
            'riwayatRombel' => $student->studentRombels,
        ], $references));
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
        $studentsData = $this->studentDataService->getAllStudentsData();

        return view('modules.buku-induk.data-siswa', array_merge([
            'title' => 'Tambah Data Siswa',
            'breadcrumbs' => BreadcrumbHelper::generate([['name' => 'Tambah Baru']]),
        ], $studentsData));
    }


    public function store(StudentStoreRequest $request, SimpanStudentService $simpanstudentService)
    {
        try {
            $simpanstudentService->store($request->validated());

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

        $this->studentUpdateService->updateBiodata($student, $validated);

        return redirect()->to(route('induk.siswa.show', $student->uuid) . '#tabs-biodata')
            ->with('success', 'Biodata berhasil diperbarui.');
    }

    public function updateOrtu(Request $request, Student $student)
    {
        $ortuData = $request->only(['ayah', 'ibu']);

        $this->studentUpdateService->updateOrtu($student, $ortuData);

        return redirect()->to(route('induk.siswa.show', $student->uuid) . '#tabs-ortu')
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

        $this->studentUpdateService->updateLokasi($student, $validated);

        return redirect()->to(route('induk.siswa.show', $student->uuid) . '#tabs-lokasi')
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

        $this->studentUpdateService->updateSosial($student, $validated);

        return redirect()->route('induk.siswa.show', $student->uuid)
            ->with('success', 'Data sosial berhasil diperbarui.')
            ->withFragment('tabs-sosial');
    }
}
