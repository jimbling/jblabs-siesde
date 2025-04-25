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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nama');
            $table->string('nipd')->nullable();
            $table->enum('jk', ['L', 'P']);
            $table->string('nisn')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nik')->nullable();
            $table->string('agama')->nullable();

            // Alamat
            $table->text('alamat')->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('dusun')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kode_pos')->nullable();

            // Lain-lain
            $table->string('jenis_tinggal')->nullable();        // bisa relasi jika banyak pilihan
            $table->string('alat_transportasi')->nullable();    // bisa relasi jika perlu
            $table->string('telepon')->nullable();
            $table->string('hp')->nullable();
            $table->string('email')->nullable();

            // KIP, SKHUN, KKS, PIP
            $table->string('skhun')->nullable();
            $table->boolean('penerima_kps')->default(false);
            $table->string('no_kps')->nullable();
            $table->boolean('penerima_kip')->default(false);
            $table->string('nomor_kip')->nullable();
            $table->string('nama_di_kip')->nullable();
            $table->string('nomor_kks')->nullable();
            $table->string('no_registrasi_akta')->nullable();

            // Bank
            $table->string('bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('rekening_atas_nama')->nullable();

            // PIP
            $table->boolean('layak_pip')->default(false);
            $table->string('alasan_layak_pip')->nullable();

            // Lainnya
            $table->string('kebutuhan_khusus')->nullable(); // bisa array/string
            $table->string('sekolah_asal')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->string('no_kk')->nullable();
            $table->integer('jumlah_saudara_kandung')->nullable();
            $table->decimal('jarak_rumah_km', 5, 2)->nullable(); // misal: 3.75
            $table->string('lintang')->nullable(); // untuk geo
            $table->string('bujur')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
