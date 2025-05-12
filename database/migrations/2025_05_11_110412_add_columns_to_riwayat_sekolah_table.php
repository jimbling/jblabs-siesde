<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('riwayat_sekolah', function (Blueprint $table) {
            $table->string('alasan_pindah')->nullable()->after('updated_at');
            $table->string('catatan_kembali')->nullable()->after('alasan_pindah');
            $table->string('dari_sekolah')->nullable()->after('catatan_kembali');
            $table->string('lama_belajar')->nullable()->after('dari_sekolah');
            $table->string('nomor_ijazah')->nullable()->after('lama_belajar');
            $table->date('tanggal_ijazah')->nullable()->after('nomor_ijazah');
            $table->string('kelas_diterima')->nullable()->after('tanggal_ijazah');
        });
    }

    public function down()
    {
        Schema::table('riwayat_sekolah', function (Blueprint $table) {
            $table->dropColumn([
                'alasan_pindah',
                'catatan_kembali',
                'dari_sekolah',
                'lama_belajar',
                'nomor_ijazah',
                'tanggal_ijazah',
                'kelas_diterima',
            ]);
        });
    }
};
