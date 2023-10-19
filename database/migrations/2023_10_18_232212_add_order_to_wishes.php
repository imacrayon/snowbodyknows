<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wishes', function (Blueprint $table) {
            $table->after('description', function ($table) {
                $table->tinyInteger('order')->default(0);
            });
        });
    }

    public function down(): void
    {
        Schema::table('wishes', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
