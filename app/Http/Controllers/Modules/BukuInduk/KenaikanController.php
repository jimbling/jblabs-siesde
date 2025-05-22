<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Akademik\Rombel\KenaikanService;
use App\Services\Akademik\Rombel\ProsesKenaikanService;

class KenaikanController extends Controller
{
    protected $kenaikanService;

    public function __construct(KenaikanService $kenaikanService)
    {
        $this->kenaikanService = $kenaikanService;
    }

    public function index(Request $request)
    {
        $data = $this->kenaikanService->getIndexData($request);
        return view('modules.buku-induk.akademik-rombel', $data);
    }

    public function getFilteredStudents(Request $request)
    {
        return response()->json($this->kenaikanService->getFilteredStudents($request));
    }

    public function filterByTingkat(Request $request)
    {
        $data = $this->kenaikanService->filterByTingkat($request);
        return view('modules.buku-induk.akademik-rombel', $data);
    }

    public function moveToNextClass(Request $request, ProsesKenaikanService $proseskenaikanService)
    {

        $siswaData = json_decode($request->input('siswa_terpilih'), true);

        if (!is_array($siswaData) || count($siswaData) === 0) {
            return back()->with('error', 'Tidak ada siswa yang dipilih.');
        }

        $request->validate([
            'tingkat_tujuan' => 'required|string',
            'semester_id' => 'required|exists:semester,id',
        ]);

        try {
            $proseskenaikanService->prosesKenaikan(
                $siswaData,
                $request->input('tingkat_tujuan'),
                $request->input('semester_id'),
                $request->input('tingkat_awal'),
                $request->input('tahun_pelajaran_awal')
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('rombel.siswa.index')->with('success', 'Siswa berhasil dipindahkan ke kelas tujuan.');
    }

    public function hapusDariRombel(Request $request)
    {
        return response()->json($this->kenaikanService->hapusDariRombel($request));
    }
}
