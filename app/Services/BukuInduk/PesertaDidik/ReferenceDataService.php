<?php

namespace App\Services\BukuInduk\PesertaDidik;

use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
use App\Models\JenisTinggal;
use App\Models\AlatTransportasi;
use App\Models\KebutuhanKhusus;

class ReferenceDataService
{
    public function getAllReferences()
    {
        return [
            'agamas' => Agama::all(),
            'alatTransportasis' => AlatTransportasi::all(),
            'jenisTinggals' => JenisTinggal::all(),
            'kebutuhanKhususes' => KebutuhanKhusus::all(),
            'pekerjaans' => Pekerjaan::all(),
            'pendidikans' => Pendidikan::all(),
            'penghasilans' => Penghasilan::all(),
        ];
    }
}
