<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsValidAndJenisToDocumentLogsTable extends Migration
{
    public function up()
    {
        Schema::table('document_logs', function (Blueprint $table) {
            $table->boolean('is_valid')->default(true)->after('dicetak_oleh');
            $table->string('jenis')->nullable()->after('is_valid');
        });
    }

    public function down()
    {
        Schema::table('document_logs', function (Blueprint $table) {
            $table->dropColumn(['is_valid', 'jenis']);
        });
    }
}
