<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentRombelTable extends Migration
{
    public function up()
    {
        Schema::create('student_rombel', function (Blueprint $table) {
            $table->id(); // ID primary key untuk student_rombel
            $table->unsignedBigInteger('siswa_id'); // Menggunakan id dari students untuk relasi
            $table->foreign('siswa_id')->references('id')->on('students')->onDelete('cascade'); // Relasi dengan students.id
            $table->unsignedBigInteger('rombel_id');
            $table->foreign('rombel_id')->references('id')->on('rombel');
            $table->unsignedBigInteger('tahun_pelajaran_id');
            $table->foreign('tahun_pelajaran_id')->references('id')->on('tahun_pelajaran');
            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semester');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_rombel');
    }
}
