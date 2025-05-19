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
        Schema::create('student_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('tipe_dokumen', [
                'kk',
                'akta_kelahiran',
                'surat_pindah',
                'ijazah_tk',
                'ijazah_sd',
                'lainnya'
            ]);
            $table->string('path_file'); // path ke file gambar/pdf
            $table->text('keterangan')->nullable(); // opsional, misal: edisi scan 2024
            $table->timestamp('tanggal_upload')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_documents');
    }
};
