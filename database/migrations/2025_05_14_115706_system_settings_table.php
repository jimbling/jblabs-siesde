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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('npsn')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('negara')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('kepala_sekolah')->nullable();
            $table->string('nip_kepala_sekolah')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->year('tahun_berdiri')->nullable();
            $table->string('jenjang_pendidikan')->nullable(); // SD, SMP, SMA, dll
            $table->string('status_sekolah')->nullable(); // Negeri / Swasta
            $table->string('kurikulum_berlaku')->nullable();
            $table->string('kop_sekolah')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
