<?php

namespace App\Services\BukuInduk\PesertaDidik;

use App\Models\Student;

class StudentUpdateService
{
    public function updateBiodata(Student $student, array $validated)
    {
        return $student->update($validated);
    }

    public function updateOrtu(Student $student, array $ortuData)
    {
        foreach (['ayah', 'ibu'] as $tipe) {
            if (!isset($ortuData[$tipe])) continue;

            $student->orangTuas()->updateOrCreate(
                ['id' => $ortuData[$tipe]['id'] ?? null],
                [
                    'tipe' => $tipe,
                    'nama' => $ortuData[$tipe]['nama'],
                    'tahun_lahir' => $ortuData[$tipe]['tahun_lahir'],
                    'nik' => $ortuData[$tipe]['nik'],
                    'pendidikan_id' => $ortuData[$tipe]['pendidikan_id'] ?? null,
                    'pekerjaan_id' => $ortuData[$tipe]['pekerjaan_id'] ?? null,
                    'penghasilan_id' => $ortuData[$tipe]['penghasilan_id'] ?? null,
                ]
            );
        }
    }

    public function updateLokasi(Student $student, array $validated)
    {
        return $student->update($validated);
    }

    public function updateSosial(Student $student, array $validated)
    {
        // Convert checkbox values to boolean
        $validated['penerima_kps'] = isset($validated['penerima_kps']);
        $validated['penerima_kip'] = isset($validated['penerima_kip']);
        $validated['layak_pip'] = isset($validated['layak_pip']);

        return $student->update($validated);
    }
}
