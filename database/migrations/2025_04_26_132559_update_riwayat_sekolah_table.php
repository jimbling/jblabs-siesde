<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_sekolah', function (Blueprint $table) {
            // Rename kolom
            $table->renameColumn('nama_sekolah', 'sekolah_asal');

            // Ubah kolom 'jenis' jadi 'jenis_pendaftar' enum baru
            $table->dropColumn('jenis'); // hapus kolom lama

            $table->enum('jenis_pendaftar', ['Siswa Baru', 'Pindahan', 'Kembali Bersekolah'])
                ->after('sekolah_asal');

            // Tambah kolom tanggal_masuk
            $table->date('tanggal_masuk')->nullable()->after('jenis_pendaftar');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_sekolah', function (Blueprint $table) {
            // Balik perubahan
            $table->renameColumn('sekolah_asal', 'nama_sekolah');

            $table->dropColumn('jenis_pendaftar');
            $table->dropColumn('tanggal_masuk');

            $table->string('jenis')->nullable();
        });
    }
};
