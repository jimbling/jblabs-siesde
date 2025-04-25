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
        Schema::create('riwayat_rombel', function (Blueprint $table) {
            $table->id();
            $table->uuid('siswa_uuid');
            $table->foreignId('rombel_id')->constrained('rombel');
            $table->year('tahun');
            $table->timestamps();

            $table->foreign('siswa_uuid')->references('uuid')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_rombel');
    }
};
