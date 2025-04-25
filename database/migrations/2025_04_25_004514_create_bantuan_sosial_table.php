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
        Schema::create('bantuan_sosial', function (Blueprint $table) {
            $table->id();
            $table->uuid('siswa_uuid');
            $table->boolean('penerima_kps')->default(false);
            $table->string('no_kps')->nullable();
            $table->boolean('penerima_kip')->default(false);
            $table->string('no_kip')->nullable();
            $table->string('nama_di_kip')->nullable();
            $table->string('no_kks')->nullable();
            $table->boolean('layak_pip')->default(false);
            $table->string('alasan_layak_pip')->nullable();
            $table->timestamps();

            $table->foreign('siswa_uuid')->references('uuid')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bantuan_sosial');
    }
};
