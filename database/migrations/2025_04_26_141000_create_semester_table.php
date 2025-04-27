<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemesterTable extends Migration
{
    public function up()
    {
        Schema::create('semester', function (Blueprint $table) {
            $table->id();
            $table->string('semester'); // Kolom untuk nama semester, seperti 'Ganjil' atau 'Genap'
            $table->foreignId('tahun_pelajaran_id')->constrained('tahun_pelajaran')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('semesters');
    }
}
