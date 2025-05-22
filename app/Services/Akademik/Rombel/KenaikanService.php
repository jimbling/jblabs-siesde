<?php

namespace App\Services\Akademik\Rombel;

use App\Models\Rombel;
use App\Models\Student;
use App\Models\StudentRombel;
use App\Models\TahunPelajaran;


class KenaikanService
{
    public function getIndexData($request)
    {
        return [
            'rombels' => Rombel::all(),
            'tahunPelajarans' => TahunPelajaran::with('semesters')->get(),
            'tingkat' => $request->get('tingkat'),
            'tahun_pelajaran_id' => $request->get('tahun_pelajaran_id'),
        ];
    }

    public function getFilteredStudents($request)
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

        return compact('students', 'tingkat', 'tahun_pelajaran_id');
    }

    public function filterByTingkat($request)
    {
        $tingkat = $request->get('tingkat');
        $rombels = Rombel::orderBy('tingkat')->get();

        if ($tingkat) {
            $students = Student::whereHas('currentRombel', function ($query) use ($tingkat) {
                $query->whereHas('rombel', function ($q) use ($tingkat) {
                    $q->where('tingkat', $tingkat);
                });
            })->with('currentRombel.rombel')->get();
        } else {
            $students = Student::doesntHave('currentRombel')->get();
        }

        return compact('tingkat', 'rombels', 'students');
    }



    public function hapusDariRombel($request)
    {
        $request->validate([
            'siswa_uuids' => 'required|array',
        ]);

        StudentRombel::whereIn('siswa_uuid', $request->siswa_uuids)->delete();

        return ['status' => 'success', 'message' => 'Siswa berhasil dihapus dari rombel.'];
    }
}
