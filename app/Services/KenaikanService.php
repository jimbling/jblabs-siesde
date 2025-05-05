<?php

namespace App\Services;

use App\Models\Rombel;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentRombel;

class KenaikanService
{
    public function prosesKenaikan(array $siswaData, string $tingkatTujuan, int $semesterId, $tingkatAwal = null, $tahunPelajaranAwal = null)
    {
        $semesterTujuan = Semester::findOrFail($semesterId);
        $tahunPelajaranTujuan = $semesterTujuan->tahun_pelajaran_id;

        $rombelTujuan = Rombel::where('tingkat', $tingkatTujuan)->firstOrFail();

        if ($tingkatAwal == $tingkatTujuan && $tahunPelajaranAwal == $tahunPelajaranTujuan) {
            throw new \Exception("Tingkat dan Tahun Pelajaran tujuan tidak boleh sama dengan yang awal.");
        }

        foreach ($siswaData as $siswa) {
            $student = Student::where('uuid', $siswa['uuid'])->firstOrFail();

            $sudahAda = StudentRombel::where('siswa_id', $student->id)
                ->where('rombel_id', $rombelTujuan->id)
                ->where('semester_id', $semesterTujuan->id)
                ->exists();

            if ($sudahAda) {
                throw new \Exception("Siswa {$student->nama} sudah terdaftar di rombel tujuan.");
            }

            StudentRombel::create([
                'siswa_id' => $student->id,
                'siswa_uuid' => $student->uuid,
                'rombel_id' => $rombelTujuan->id,
                'tahun_pelajaran_id' => $tahunPelajaranTujuan,
                'semester_id' => $semesterTujuan->id,
            ]);
        }
    }
}
