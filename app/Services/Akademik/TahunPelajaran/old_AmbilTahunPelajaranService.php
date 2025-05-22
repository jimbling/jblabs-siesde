<?php

namespace App\Services\Akademik\TahunPelajaran;

use App\Models\TahunPelajaran;
use Carbon\Carbon;

class AmbilTahunPelajaranService
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
}
