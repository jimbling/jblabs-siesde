<?php

namespace App\Imports;

use App\Models\Pendidikan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PendidikanImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Mengimpor data ke model Pendidikan
        return new Pendidikan([
            'jenjang' => $row['jenjang'],  // Sesuaikan dengan header kolom Excel
        ]);
    }
}
