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
        // database/migrations/xxxx_xx_xx_xxxxxx_add_akademik_references_to_foto_siswa_table.php
        Schema::table('foto_siswa', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_pelajaran_id')->nullable()->after('siswa_uuid');
            $table->unsignedBigInteger('semester_id')->nullable()->after('tahun_pelajaran_id');
            $table->unsignedBigInteger('rombel_id')->nullable()->after('semester_id');

            $table->foreign('tahun_pelajaran_id')->references('id')->on('tahun_pelajaran');
            $table->foreign('semester_id')->references('id')->on('semester');
            $table->foreign('rombel_id')->references('id')->on('rombel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foto_siswa', function (Blueprint $table) {
            //
        });
    }
};
