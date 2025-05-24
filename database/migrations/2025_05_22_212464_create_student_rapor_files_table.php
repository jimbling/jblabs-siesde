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
        Schema::table('student_rapor_files', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_pelajaran_id')->nullable()->after('student_uuid');
            // Jika mau, tambahkan foreign key juga, contoh:
            // $table->foreign('tahun_pelajaran_id')->references('id')->on('tahun_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_rapor_files');
    }
};
