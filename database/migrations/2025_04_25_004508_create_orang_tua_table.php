<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->uuid('siswa_uuid');
            $table->enum('tipe', ['ayah', 'ibu']);
            $table->string('nama')->nullable();
            $table->year('tahun_lahir')->nullable();
            $table->foreignId('pendidikan_id')->nullable()->constrained('pendidikan');
            $table->foreignId('pekerjaan_id')->nullable()->constrained('pekerjaan');
            $table->foreignId('penghasilan_id')->nullable()->constrained('penghasilan');
            $table->string('nik')->nullable();
            $table->timestamps();

            $table->foreign('siswa_uuid')->references('uuid')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_tua');
    }
};
