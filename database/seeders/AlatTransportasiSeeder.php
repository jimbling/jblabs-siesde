<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlatTransportasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Jalan Kaki',
            'Kendaraan Pribadi',
            'Kendaraan Umum/Angkot/Pete-pete',
            'Jemputan Sekolah',
            'Kereta Api',
            'Ojek',
            'Andong/Bendi/Sado/Dokar/Delman/Beca',
            'Perahu Penyebrangan/Rakit/Getek',
            'Lainnya',
        ];

        foreach ($data as $nama) {
            DB::table('alat_transportasi')->insert([
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
