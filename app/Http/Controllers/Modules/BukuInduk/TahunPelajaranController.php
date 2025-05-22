<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Akademik\TahunPelajaran\TahunPelajaranService;
use App\Helpers\BreadcrumbHelper;
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
        $data = $this->tahunPelajaranService->formatTahunPelajaranData($tahunPelajaran);

        return view('modules.buku-induk.akademik-tahun-pelajaran', [
            'title' => 'Data Tahun Pelajaran',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Tahun Pelajaran']
            ]),
            'data' => $data,
        ]);
    }

    public function store(StoreTahunPelajaranRequest $request)
    {
        $validated = $request->validated();
        $this->tahunPelajaranService->storeTahunPelajaran($validated);

        return redirect()->route('induk.akademik.tahun-pelajaran.index')
            ->with('success', 'Tahun pelajaran berhasil ditambahkan.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }

        try {
            $this->tahunPelajaranService->bulkDestroyTahunPelajaran($ids);
            return back()->with('success', 'Data Tahun Pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
