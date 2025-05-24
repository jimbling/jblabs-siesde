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
            $table->string('mime_type')->nullable()->after('file_id_drive');
            $table->string('drive_url')->nullable()->after('mime_type');
        });
    }

    public function down()
    {
        Schema::table('student_rapor_files', function (Blueprint $table) {
            $table->dropColumn(['mime_type', 'drive_url']);
        });
    }
};
