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
        Schema::table('students', function (Blueprint $table) {
            // Menghapus kolom 'sekolah_asal'
            $table->dropColumn('sekolah_asal');

            // Menambahkan kolom 'riwayat_sekolah_id' yang berelasi dengan tabel 'riwayat_sekolah'
            $table->foreignId('riwayat_sekolah_id')->nullable()->constrained('riwayat_sekolah')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
