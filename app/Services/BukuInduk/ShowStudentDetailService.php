<?php

namespace App\Services\BukuInduk;

use App\Models\Student;
use App\Models\DocumentLog;

class ShowStudentDetailService
{
    public function getStudentDetail($uuid)
    {
        $student = Student::with([
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
            'dokumen'
        ])->where('uuid', $uuid)->firstOrFail();

        $student->can_generate_pdf = !is_null($student->nomor_dokumen);

        return [
            'student' => $student,
            'fotoSiswa' => $student->fotoSiswa()->with('tahunPelajaran')->orderByDesc('created_at')->take(3)->get(),
            'riwayatSekolah' => $student->riwayatSekolah,
            'riwayatRombel' => $student->studentRombels,
            'log' => DocumentLog::where('student_id', $student->id)->first(),
            'title' => 'Detail Siswa - ' . $student->nama,
        ];
    }
}
