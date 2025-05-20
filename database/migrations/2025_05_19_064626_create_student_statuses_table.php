<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('student_statuses', function (Blueprint $table) {
            $table->id();
            $table->uuid('student_uuid'); // relasi ke students.uuid
            $table->enum('status', ['aktif', 'lulus', 'pindah', 'keluar']);
            $table->date('tanggal')->nullable(); // tanggal status berubah
            $table->string('alasan')->nullable(); // alasan jika ada
            $table->timestamps();

            // foreign key (opsional jika pakai UUID, pastikan UUID di student unique)
            $table->foreign('student_uuid')->references('uuid')->on('students')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_statuses');
    }
}
