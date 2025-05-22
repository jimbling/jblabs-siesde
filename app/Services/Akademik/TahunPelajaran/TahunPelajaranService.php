<?php

namespace App\Services\Akademik\TahunPelajaran;

use Carbon\Carbon;
use App\Models\TahunPelajaran;

class TahunPelajaranService
{
    public function getAllTahunPelajaran()
    {
        return TahunPelajaran::with('semesters') // tanpa filter di eager loading
            ->latest()
            ->get()
            ->map(function ($tp) {
                $semesters = $tp->semesters;

                $tp->tanggal_mulai_indo = optional($semesters->min('tanggal_mulai'))
                    ? Carbon::parse($semesters->min('tanggal_mulai'))->translatedFormat('d F Y')
                    : '-';

                $tp->tanggal_selesai_indo = optional($semesters->max('tanggal_selesai'))
                    ? Carbon::parse($semesters->max('tanggal_selesai'))->translatedFormat('d F Y')
                    : '-';

                return $tp;
            });
    }
    public function formatTahunPelajaranData($tahunPelajaran)
    {
        $data = [];

        foreach ($tahunPelajaran as $tp) {
            if ($tp->semesters->count()) {
                foreach ($tp->semesters as $semester) {
                    $data[] = (object) [
                        'tp_id' => $tp->id,
                        'tahun_ajaran' => $tp->tahun_ajaran,
                        'tanggal_mulai_indo' => $semester->tanggal_mulai_indo,
                        'tanggal_selesai_indo' => $semester->tanggal_selesai_indo,
                        'semester' => $semester,
                    ];
                }
            } else {
                $data[] = (object) [
                    'tp_id' => $tp->id,
                    'tahun_ajaran' => $tp->tahun_ajaran,
                    'tanggal_mulai_indo' => null,
                    'tanggal_selesai_indo' => null,
                    'semester' => null,
                ];
            }
        }

        return $data;
    }

    public function storeTahunPelajaran(array $validated)
    {
        return TahunPelajaran::create($validated);
    }

    public function bulkDestroyTahunPelajaran(array $ids)
    {
        $tahunPelajaranWithSemesters = TahunPelajaran::whereIn('id', $ids)->whereHas('semesters')->get();

        if ($tahunPelajaranWithSemesters->isNotEmpty()) {
            throw new \Exception('Data Tahun Pelajaran yang dipilih masih memiliki semester. Hapus semester terlebih dahulu sebelum menghapus Tahun Pelajaran.');
        }

        return TahunPelajaran::whereIn('id', $ids)->delete();
    }
}
