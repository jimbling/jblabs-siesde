<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kesehatan_siswa', function (Blueprint $table) {
            $table->id();
            $table->uuid('siswa_uuid'); // Menggunakan UUID
            $table->foreign('siswa_uuid')->references('uuid')->on('students')->onDelete('cascade');
            $table->string('golongan_darah')->nullable();
            $table->text('penyakit_diderita')->nullable();
            $table->text('kelainan_jasmani')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kesehatan_siswa');
    }
};
