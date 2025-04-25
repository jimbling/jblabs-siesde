<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempatTinggalSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Bersama Orang Tua',
            'Wali',
            'Kos',
            'Asrama',
            'Panti Asuhan',
        ];

        foreach ($data as $nama) {
            DB::table('jenis_tinggal')->insert([
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
