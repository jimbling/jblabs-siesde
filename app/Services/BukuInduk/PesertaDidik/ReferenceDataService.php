<?php

namespace App\Services\BukuInduk\PesertaDidik;

use App\Models\Agama;
use App\Models\Semester;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penghasilan;
use App\Models\JenisTinggal;
use App\Models\TahunPelajaran;
use App\Models\KebutuhanKhusus;
use App\Models\AlatTransportasi;

class ReferenceDataService
{
    public function getAllReferences()
    {
        return [
            // data referensi yang sudah ada
            'agamaData' => Agama::all(),
            'jenisTinggalData' => JenisTinggal::all(),
            'alatTransportasiData' => AlatTransportasi::all(),
            'kebutuhanKhususData' => KebutuhanKhusus::all(),
            'pendidikanData' => Pendidikan::all(),
            'penghasilanData' => Penghasilan::all(),
            'pekerjaanData' => Pekerjaan::all(),

            'agamaList' => Agama::pluck('nama', 'id'),
            'alatTransportasiList' => AlatTransportasi::pluck('nama', 'id'),
            'jenisTinggalList' => JenisTinggal::pluck('nama', 'id'),
            'kebutuhanKhususList' => KebutuhanKhusus::pluck('nama', 'id'),
            'pekerjaanList' => Pekerjaan::pluck('nama', 'id'),
            'pendidikanList' => Pendidikan::pluck('jenjang', 'id'),
            'penghasilanList' => Penghasilan::pluck('rentang', 'id'),

            // tambah data Tahun Pelajaran dan Semester
            'semesterList' => Semester::with('tahunPelajaran')->orderBy('id')->get(),
        ];
    }
}
