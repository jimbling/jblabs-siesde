<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKebutuhanKhususSiswaTable extends Migration
{
    public function up(): void
    {
        Schema::create('kebutuhan_khusus_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('kebutuhan_khusus_id');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('kebutuhan_khusus_id')->references('id')->on('kebutuhan_khusus')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kebutuhan_khusus_siswa');
    }
}
