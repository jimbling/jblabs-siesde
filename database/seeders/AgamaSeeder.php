<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgamaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Islam',
            'Kristen',
            'Katholik',
            'Hindhu',
            'Budha',
            'Khonghucu',
            'Kepercayaan kepada Tuhan YME',
            'Lainnya',
        ];

        foreach ($data as $nama) {
            DB::table('agama')->insert([
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
