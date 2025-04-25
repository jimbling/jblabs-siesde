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
        Schema::create('foto_siswa', function (Blueprint $table) {
            $table->id();
            $table->uuid('siswa_uuid');
            $table->string('path_foto'); // path atau url
            $table->string('kelas')->nullable(); // misal: "Kelas 1"
            $table->timestamps();

            $table->foreign('siswa_uuid')->references('uuid')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_siswa');
    }
};
