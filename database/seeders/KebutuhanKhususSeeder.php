<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KebutuhanKhususSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Tidak',
            'Netra (A)',
            'Rungu',
            'Grahita Ringan (C)',
            'Grahita Sedang',
            'Daksa Ringan (D)',
            'Daksa Sedang (D1)',
            'Wicara (F)',
            'Tuna Ganda (G)',
            'Hiper Aktif (H)',
            'Cerdas Istimewa (I)',
            'Bakat Istimewa',
            'Kesulitan Belajar (K)',
            'Narkoba (N)',
            'Indigo (O)',
            'Down Syndrome (P)',
            'Autis (Q)',
        ];

        foreach ($data as $nama) {
            DB::table('kebutuhan_khusus')->insert([
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
