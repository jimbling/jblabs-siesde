<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalMulaiSelesaiToSemesterTable extends Migration
{
    public function up(): void
    {
        Schema::table('semester', function (Blueprint $table) {
            $table->date('tanggal_mulai')->after('tahun_pelajaran_id');
            $table->date('tanggal_selesai')->after('tanggal_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('semester', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai']);
        });
    }
}
