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
            $table->string('nama_panggilan')->nullable()->after('nama');
            $table->unsignedTinyInteger('saudara_tiri')->nullable()->after('jumlah_saudara_kandung');
            $table->unsignedTinyInteger('saudara_angkat')->nullable()->after('saudara_tiri');
            $table->string('status_anak')->nullable()->after('anak_ke');
            $table->string('bahasa_keseharian')->nullable()->after('status_anak');
            $table->string('kabupaten')->nullable()->after('kecamatan');
            $table->string('provinsi')->nullable()->after('kabupaten');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'nama_panggilan',
                'saudara_tiri',
                'saudara_angkat',
                'status_anak',
                'bahasa_keseharian',
                'kabupaten',
                'provinsi',
            ]);
        });
    }
};
