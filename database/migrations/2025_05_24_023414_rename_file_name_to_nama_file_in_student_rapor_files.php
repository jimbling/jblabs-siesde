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
        Schema::table('student_rapor_files', function (Blueprint $table) {
            $table->renameColumn('file_name', 'nama_file');
        });
    }

    public function down()
    {
        Schema::table('student_rapor_files', function (Blueprint $table) {
            $table->renameColumn('nama_file', 'file_name');
        });
    }
};
