<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_fisik_siswa', function (Blueprint $table) {
            $table->id();
            $table->uuid('siswa_uuid'); // Menggunakan UUID
            $table->foreign('siswa_uuid')->references('uuid')->on('students')->onDelete('cascade');
            $table->foreignId('semester_id')->constrained('semester')->onDelete('cascade'); // foreign ke semester
            $table->integer('tinggi_badan')->nullable();     // cm
            $table->integer('berat_badan')->nullable();      // kg
            $table->integer('lingkar_kepala')->nullable();   // cm
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_fisik_siswa');
    }
};
