<?php

namespace App\Services\BukuInduk;

use App\Models\Student;

class GenerateNomorDokumenServices
{
    public function generateNomorDokumen(array $studentIds)
    {
        $students = Student::whereIn('id', $studentIds)->get();
        $tahun = date('Y');
        $existingStudents = [];

        foreach ($students as $student) {
            if ($student->nomor_dokumen) {
                $existingStudents[] = $student->nama;
            } else {
                do {
                    $generatedNumber = 'BINDUK-' . $tahun . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
                } while (Student::where('nomor_dokumen', $generatedNumber)->exists());

                $student->nomor_dokumen = $generatedNumber;
                $student->save();
            }
        }

        return $existingStudents;
    }
}
