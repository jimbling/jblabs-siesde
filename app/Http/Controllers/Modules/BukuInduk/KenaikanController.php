<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use App\Models\Rombel;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentRombel;
use App\Helpers\BreadcrumbHelper;
use App\Services\KenaikanService;
use App\Http\Controllers\Controller;

class KenaikanController extends Controller
{
    public function index(Request $request)
    {
        $rombels = Rombel::all();
        $tahunPelajarans = \App\Models\TahunPelajaran::with('semesters')->get();

        $tingkat = $request->get('tingkat');
        $tahun_pelajaran_id = $request->get('tahun_pelajaran_id');

        return view('modules.buku-induk.akademik-rombel', [
            'title' => 'Pengaturan Rombel',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Akademik'],
                ['name' => 'Data Rombel'],
            ]),
            'rombels' => $rombels,
            'tahunPelajarans' => $tahunPelajarans,
            'tingkat' => $tingkat,
            'tahun_pelajaran_id' => $tahun_pelajaran_id
        ]);
    }


    public function getFilteredStudents(Request $request)
    {
        $tingkat = $request->get('tingkat');
        $tahun_pelajaran_id = $request->get('tahun_pelajaran_id');

        if ($tingkat && $tahun_pelajaran_id) {

            $students = Student::whereHas('studentRombels', function ($query) use ($tingkat, $tahun_pelajaran_id) {
                $query->where('tahun_pelajaran_id', $tahun_pelajaran_id)
                    ->whereHas('rombel', function ($q) use ($tingkat) {
                        $q->where('tingkat', $tingkat);
                    });
            })
                ->with([
                    'studentRombels' => function ($query) use ($tahun_pelajaran_id) {
                        $query->where('tahun_pelajaran_id', $tahun_pelajaran_id);
                    },
                    'studentRombels.rombel',
                    'studentRombels.tahunPelajaran'
                ])
                ->get();
        } else {

            $students = Student::whereDoesntHave('studentRombels')->get();
        }

        return response()->json([
            'students' => $students,
            'tingkat' => $tingkat,
            'tahun_pelajaran_id' => $tahun_pelajaran_id,
        ]);
    }


    public function filterByTingkat(Request $request)
    {
        $tingkat = $request->get('tingkat');
        $rombels = Rombel::orderBy('tingkat')->get();

        if ($tingkat) {
            $students = \App\Models\Student::whereHas('currentRombel', function ($query) use ($tingkat) {
                $query->whereHas('rombel', function ($q) use ($tingkat) {
                    $q->where('tingkat', $tingkat);
                });
            })->with('currentRombel.rombel')->get();
        } else {

            $students = \App\Models\Student::doesntHave('currentRombel')->get();
        }

        return view('modules.buku-induk.akademik-rombel', compact('tingkat', 'rombels', 'students'));
    }



    public function moveToNextClass(Request $request, KenaikanService $kenaikanService)
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
            $kenaikanService->prosesKenaikan(
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
        $request->validate([
            'siswa_uuids' => 'required|array',
        ]);

        StudentRombel::whereIn('siswa_uuid', $request->siswa_uuids)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Siswa berhasil dihapus dari rombel.'
        ]);
    }
}
