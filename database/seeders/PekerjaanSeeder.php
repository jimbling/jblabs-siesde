<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Tidak bekerja',
            'Nelayan',
            'Petani',
            'Peternak',
            'PNS/TNI/POLRI',
            'Karyawan Swasta',
            'Pedagang Kecil',
            'Pedagang Besar',
            'Wiraswasta',
            'Wirausaha',
            'Buruh',
            'Pensiunan',
        ];

        foreach ($data as $nama) {
            DB::table('pekerjaan')->insert([
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
