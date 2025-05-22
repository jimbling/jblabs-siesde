<?php

namespace App\Services\Akademik;

use App\Models\Semester;
use App\Models\TahunPelajaran;

class SemesterService
{
    public function storeSemester(array $validated)
    {
        if ($validated['is_aktif']) {
            Semester::where('tahun_pelajaran_id', $validated['tahun_pelajaran_id'])
                ->update(['is_aktif' => false]);
        }

        return Semester::create($validated);
    }

    public function aktifkanSemester($tahunPelajaranId, $semesterId)
    {
        $tahunPelajaran = TahunPelajaran::findOrFail($tahunPelajaranId);
        $semester = $tahunPelajaran->semesters()->where('id', $semesterId)->firstOrFail();

        if (Semester::where('is_aktif', true)->where('id', '!=', $semester->id)->exists()) {
            throw new \Exception('Sudah ada semester aktif lainnya. Nonaktifkan dulu sebelum mengaktifkan semester ini.');
        }

        $tahunPelajaran->semesters()->update(['is_aktif' => false]);
        return $semester->update(['is_aktif' => true]);
    }

    public function nonaktifkanSemester($tahunPelajaranId, $semesterId)
    {
        $tahunPelajaran = TahunPelajaran::findOrFail($tahunPelajaranId);
        $semester = $tahunPelajaran->semesters()->where('id', $semesterId)->firstOrFail();

        if (!$semester->is_aktif) {
            throw new \Exception("Semester {$semester->nama} sudah dalam keadaan nonaktif.");
        }

        return $semester->update(['is_aktif' => false]);
    }

    public function destroySemester($tahunPelajaranId)
    {
        $tahunPelajaran = TahunPelajaran::findOrFail($tahunPelajaranId);
        $semester = $tahunPelajaran->semesters->first();

        return $semester->delete();
    }
}
