<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Tidak sekolah',
            'Putus SD',
            'SD Sederajat',
            'SMP Sederajat',
            'SMA Sederajat',
            'D1',
            'D2',
            'D3',
            'D4/S1',
            'S2',
            'S3',
        ];

        foreach ($data as $nama) {
            DB::table('pendidikan')->insert([
                'jenjang' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
