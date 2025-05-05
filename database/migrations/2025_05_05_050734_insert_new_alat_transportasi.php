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
            ['nama' => 'Mobil/bus antar jemput'],
            ['nama' => 'Kuda'],
            ['nama' => 'Sepeda'],
            ['nama' => 'Mobil Pribadi'],
        ];

        DB::table('alat_transportasi')->insert($data);
    }

    public function down()
    {
        $items = [
            'Mobil/bus antar jemput',
            'Kuda',
            'Sepeda',
            'Mobil Pribadi',
        ];

        DB::table('alat_transportasi')->whereIn('nama', $items)->delete();
    }
};
