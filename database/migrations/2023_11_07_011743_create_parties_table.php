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
        Schema::dropIfExists('parties'); // debug
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('user_id created by')->constrained('users');
            $table->string('name');
            $table->text('description', 65535)->nullable();
            $table->string('address', 255)->nullable();
            $table->float('lat', 10, 6)->nullable();
            $table->float('lng', 10, 6)->nullable();
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->uuid('invite_code')->unique();
            $table->string('image_name')->nullable(); // Maybe a background image located at public/images/parties/d/4/d/d4d359e1-70bf-4e0a-9fb9-0f3ed30d4132.jpg
            $table->integer('file_id')->nullable(); // future files table with blob content to auto-generate a hardcopy for consumption with compression!?
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
