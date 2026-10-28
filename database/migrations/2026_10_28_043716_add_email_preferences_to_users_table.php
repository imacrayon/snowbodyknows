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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('receives_wish_emails')->default(true)->after('last_login_at');
            $table->boolean('receives_comment_emails')->default(true)->after('receives_wish_emails');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['receives_wish_emails', 'receives_comment_emails']);
        });
    }
};
