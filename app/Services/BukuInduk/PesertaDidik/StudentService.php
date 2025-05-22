<?php

namespace App\Services\BukuInduk\PesertaDidik;

use App\Models\Student;

class StudentService
{
    public function getActiveStudents()
    {
        return Student::whereHas('statusTerakhir', function ($query) {
            $query->where('status', 'aktif');
        })->orderBy('nipd', 'asc')->get();
    }

    public function getStudentDetails($uuid)
    {
        return Student::with([
            'agama',
            'alatTransportasi',
            'jenisTinggal',
            'orangTuas.pendidikan',
            'orangTuas.pekerjaan',
            'orangTuas.penghasilan',
            'riwayatSekolah',
            'studentRombels.tahunPelajaran',
            'studentRombels.semester',
            'studentRombels.rombel',
            'fotoTerbaru',
        ])->where('uuid', $uuid)->firstOrFail();
    }
}
