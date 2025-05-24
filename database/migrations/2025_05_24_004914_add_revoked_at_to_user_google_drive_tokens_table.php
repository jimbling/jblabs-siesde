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
        Schema::table('user_google_drive_tokens', function (Blueprint $table) {
            $table->timestamp('revoked_at')->nullable()->after('connected_at');
        });
    }

    public function down()
    {
        Schema::table('user_google_drive_tokens', function (Blueprint $table) {
            $table->dropColumn('revoked_at');
        });
    }
};
