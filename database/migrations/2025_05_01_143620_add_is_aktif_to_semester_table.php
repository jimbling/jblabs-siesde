<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAktifToSemesterTable extends Migration
{
    public function up()
    {
        Schema::table('semester', function (Blueprint $table) {
            $table->boolean('is_aktif')->default(false)->after('tahun_pelajaran_id');
        });
    }

    public function down()
    {
        Schema::table('semester', function (Blueprint $table) {
            $table->dropColumn('is_aktif');
        });
    }
}
