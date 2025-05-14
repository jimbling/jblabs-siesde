<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();                          // Menyimpan UUID
            $table->unsignedBigInteger('student_id');                  // Menyimpan student_id
            $table->string('jenis_dokumen', 50);                       // Menyimpan jenis dokumen (misalnya 'buku_induk')
            $table->string('nomor_dokumen', 50);                       // Menyimpan nomor dokumen (misalnya BINDUK-2024-00012)
            $table->unsignedBigInteger('dicetak_oleh');                // Menyimpan user_id yang mencetak dokumen
            $table->dateTime('waktu_cetak');                            // Menyimpan waktu dokumen dicetak
            $table->text('keterangan')->nullable();                     // Menyimpan keterangan opsional
            $table->timestamps();                                       // Kolom created_at dan updated_at

            // Foreign keys
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('dicetak_oleh')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_logs');
    }
    protected $casts = [
        'waktu_cetak' => 'datetime',
    ];
}
