<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileInfoToUserGoogleDriveTokensTable extends Migration
{
    public function up(): void
    {
        Schema::table('user_google_drive_tokens', function (Blueprint $table) {
            $table->string('name')->nullable()->after('connected_at');
            $table->string('email')->nullable()->after('name');
            $table->string('picture')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('user_google_drive_tokens', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'picture']);
        });
    }
}
