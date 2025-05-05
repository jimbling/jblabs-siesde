<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $data = [
            ['nama' => 'Tenaga Kerja Indonesia'],
            ['nama' => 'Karyawan BUMN'],
            ['nama' => 'Tidak dapat diterapkan'],
            ['nama' => 'Sudah Meninggal'],
            ['nama' => 'Lainnya'],
        ];

        DB::table('pekerjaan')->insert($data);
    }

    public function down()
    {
        $pekerjaans = [
            'Tenaga Kerja Indonesia',
            'Karyawan BUMN',
            'Tidak dapat diterapkan',
            'Sudah Meninggal',
            'Lainnya',
        ];

        DB::table('pekerjaan')->whereIn('nama', $pekerjaans)->delete();
    }
};
