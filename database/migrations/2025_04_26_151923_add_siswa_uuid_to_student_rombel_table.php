<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiswaUuidToStudentRombelTable extends Migration
{
    public function up()
    {
        Schema::table('student_rombel', function (Blueprint $table) {
            // Menambahkan kolom siswa_uuid
            $table->uuid('siswa_uuid')->nullable();

            // Menambahkan index untuk mempercepat pencarian berdasarkan siswa_uuid
            $table->index('siswa_uuid');
        });
    }

    public function down()
    {
        Schema::table('student_rombel', function (Blueprint $table) {
            // Menghapus kolom siswa_uuid jika rollback
            $table->dropColumn('siswa_uuid');
        });
    }
}
