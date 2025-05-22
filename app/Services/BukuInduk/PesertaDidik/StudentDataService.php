<?php

namespace App\Services\BukuInduk\PesertaDidik;

use App\Models\Student;
use App\Models\Agama;
use App\Models\AlatTransportasi;
use App\Models\JenisTinggal;
use App\Models\KebutuhanKhusus;

class StudentDataService
{
    public function getAllStudentsData()
    {
        return [
            'students' => Student::all(),
            'totalStudents' => Student::count(),
            'agamas' => Agama::all(),
            'alatTransportasis' => AlatTransportasi::all(),
            'jenisTinggals' => JenisTinggal::all(),
            'kebutuhanKhususes' => KebutuhanKhusus::all(),
        ];
    }
}
