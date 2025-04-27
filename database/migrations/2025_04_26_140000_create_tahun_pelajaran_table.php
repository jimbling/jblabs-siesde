<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahunPelajaranTable extends Migration
{
    public function up()
    {
        Schema::create('tahun_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran'); // Misal: 2024/2025
            $table->date('tanggal_mulai'); // Tanggal mulai tahun ajaran
            $table->date('tanggal_selesai'); // Tanggal selesai tahun ajaran
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tahun_pelajaran');
    }
}
