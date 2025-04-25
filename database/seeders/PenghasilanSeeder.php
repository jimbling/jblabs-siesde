<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenghasilanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            '< Rp. 500.000',
            'Rp. 500.000 - Rp. 999.999',
            'Rp. 1.000.000 - Rp. 1.999.999',
            'Rp. 2.000.000 - Rp. 4.999.999',
            'Rp. 5.000.000 - Rp. 20.000.000',
            'Rp. 20.000.000',
            'Tidak Berpenghasilan',
        ];

        foreach ($data as $nama) {
            DB::table('penghasilan')->insert([
                'rentang' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
