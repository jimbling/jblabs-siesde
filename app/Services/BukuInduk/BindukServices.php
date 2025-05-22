<?php

namespace App\Services\BukuInduk;

use App\Models\Student;
use App\Helpers\BreadcrumbHelper;


class BindukServices
{
    public function getFilteredStudents($filter)
    {
        $students = Student::with('statusTerakhir')
            ->when($filter === 'no_nomor_dokumen', function ($query) {
                return $query->whereNull('nomor_dokumen');
            })
            ->get();

        foreach ($students as $student) {
            $student->can_generate_pdf = !is_null($student->nomor_dokumen);
        }

        return $students;
    }

    public function getBreadcrumbs()
    {
        return BreadcrumbHelper::generate([['name' => 'Data Siswa Buku Induk']]);
    }
}
