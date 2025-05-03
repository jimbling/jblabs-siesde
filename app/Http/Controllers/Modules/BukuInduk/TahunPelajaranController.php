<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use App\Services\TahunPelajaranService;
use App\Http\Requests\StoreTahunPelajaranRequest;

class TahunPelajaranController extends Controller
{
    protected $tahunPelajaranService;

    public function __construct(TahunPelajaranService $tahunPelajaranService)
    {
        $this->tahunPelajaranService = $tahunPelajaranService;
    }

    public function index()
    {
        $tahunPelajaran = $this->tahunPelajaranService->getAllTahunPelajaran();

        // Flatten agar 1 baris per semester
        $data = [];
        foreach ($tahunPelajaran as $tp) {
            if ($tp->semesters->count()) {
                foreach ($tp->semesters as $semester) {
                    $data[] = (object) [
                        'tp_id' => $tp->id,
                        'tahun_ajaran' => $tp->tahun_ajaran,
                        'tanggal_mulai_indo' => $semester->tanggal_mulai_indo, // ambil dari semester
                        'tanggal_selesai_indo' => $semester->tanggal_selesai_indo, // ambil dari semester
                        'semester' => $semester,
                    ];
                }
            } else {
                // Tidak punya semester, jadi tanggal tidak bisa ditampilkan
                $data[] = (object) [
                    'tp_id' => $tp->id,
                    'tahun_ajaran' => $tp->tahun_ajaran,
                    'tanggal_mulai_indo' => null,
                    'tanggal_selesai_indo' => null,
                    'semester' => null,
                ];
            }
        }


        return view('modules.buku-induk.akademik-tahun-pelajaran', [
            'title' => 'Data Tahun Pelajaran',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Tahun Pelajaran']
            ]),
            'data' => $data, // <--- ini yang dipakai di blade
        ]);
    }




    public function store(StoreTahunPelajaranRequest $request)
    {
        // Validasi  oleh FormRequest
        $validated = $request->validated();

        // Buat data TahunPelajaran baru
        TahunPelajaran::create($validated);

        return redirect()->route('induk.akademik.tahun-pelajaran.index')
            ->with('success', 'Tahun pelajaran berhasil ditambahkan.');
    }





    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $tahunPelajaranWithSemesters = TahunPelajaran::whereIn('id', $ids)
                ->whereHas('semesters')
                ->get();
            if ($tahunPelajaranWithSemesters->isNotEmpty()) {
                return back()->with('error', 'Data Tahun Pelajaran yang dipilih masih memiliki semester. Hapus semester terlebih dahulu sebelum menghapus Tahun Pelajaran.');
            }
            TahunPelajaran::whereIn('id', $ids)->delete();
            return back()->with('success', 'Data Tahun Pelajaran berhasil dihapus.');
        }
        return back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
    }
}
