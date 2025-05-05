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
            ['jenjang' => 'D4'],
            ['jenjang' => 'Informal'],
            ['jenjang' => 'Lainnya'],
            ['jenjang' => 'Non Formal'],
            ['jenjang' => 'Paket A'],
            ['jenjang' => 'Paket B'],
            ['jenjang' => 'Paket C'],
            ['jenjang' => 'PAUD'],
            ['jenjang' => 'Profesi'],
            ['jenjang' => 'S2 Terapan'],
            ['jenjang' => 'S3 Terapan'],
            ['jenjang' => 'SD / Sederajat'],
            ['jenjang' => 'SMP / Sederajat'],
            ['jenjang' => 'SMA / Sederajat'],
            ['jenjang' => 'Sp-1'],
            ['jenjang' => 'Sp-2'],
            ['jenjang' => 'TK / Sederajat'],
        ];

        DB::table('pendidikan')->insert($data);
    }

    public function down()
    {
        $jenjangs = [
            'D4',
            'Informal',
            'Lainnya',
            'Non Formal',
            'Paket A',
            'Paket B',
            'Paket C',
            'PAUD',
            'Profesi',
            'S2 Terapan',
            'S3 Terapan',
            'SD / Sederajat',
            'SMP / Sederajat',
            'SMA / Sederajat',
            'Sp-1',
            'Sp-2',
            'TK / Sederajat',
        ];

        DB::table('pendidikan')->whereIn('jenjang', $jenjangs)->delete();
    }
};
