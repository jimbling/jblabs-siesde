<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use App\Models\Rombel;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentRombel;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;

class KenaikanController extends Controller
{
    public function index(Request $request)
    {
        $rombels = Rombel::all();
        $tahunPelajarans = \App\Models\TahunPelajaran::all();

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
            // Jika parameter ada, ambil siswa yang sudah memiliki rombel tertentu
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
            // Jika parameter kosong, ambil siswa yang belum punya rombel sama sekali
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
            // Ambil siswa yang belum punya rombel
            $students = \App\Models\Student::doesntHave('currentRombel')->get();
        }

        return view('modules.buku-induk.akademik-rombel', compact('tingkat', 'rombels', 'students'));
    }



    public function moveToNextClass(Request $request)
    {


        // Decode siswa_terpilih dari JSON string menjadi array
        $siswaData = json_decode($request->input('siswa_terpilih'), true);



        // Validasi dasar
        if (!is_array($siswaData) || count($siswaData) === 0) {
            return back()->with('error', 'Tidak ada siswa yang dipilih.');
        }

        // Validasi nilai lainnya
        $request->validate([
            'tingkat_tujuan' => 'required|string',
            'tahun_pelajaran_tujuan' => 'required|exists:tahun_pelajaran,id',
        ]);

        // Validasi setiap siswa: pastikan uuid ada di database
        foreach ($siswaData as $siswa) {
            if (!isset($siswa['uuid']) || !\App\Models\Student::where('uuid', $siswa['uuid'])->exists()) {
                return back()->with('error', 'Salah satu siswa tidak valid.');
            }
        }

        // Ambil data rombel tujuan berdasarkan tingkat
        $rombelTujuan = Rombel::where('tingkat', $request->input('tingkat_tujuan'))->first();

        if (!$rombelTujuan) {
            return back()->with('error', 'Rombel untuk tingkat tujuan tidak ditemukan.');
        }

        if (
            $request->input('tingkat_awal') == $request->input('tingkat_tujuan') &&
            $request->input('tahun_pelajaran_awal') == $request->input('tahun_pelajaran_tujuan')
        ) {
            return back()->with('error', 'Tingkat dan Tahun Pelajaran tujuan tidak boleh sama dengan yang awal.');
        }


        // Proses perpindahan siswa
        foreach ($siswaData as $siswa) {
            $student = \App\Models\Student::where('uuid', $siswa['uuid'])->first();

            // Cek apakah sudah ada entri yang sama
            $sudahAda = \App\Models\StudentRombel::where('siswa_id', $student->id)
                ->where('rombel_id', $rombelTujuan->id)
                ->where('tahun_pelajaran_id', $request->input('tahun_pelajaran_tujuan'))
                ->exists();

            if ($sudahAda) {
                return back()->with('error', "Siswa {$student->nama} sudah terdaftar di rombel tujuan untuk tahun pelajaran ini.");
            }

            // Simpan riwayat rombel
            \App\Models\StudentRombel::create([
                'siswa_id' => $student->id,
                'siswa_uuid' => $student->uuid,
                'rombel_id' => $rombelTujuan->id,
                'tahun_pelajaran_id' => $request->input('tahun_pelajaran_tujuan'),
                'semester_id' => 1, // default
            ]);
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
