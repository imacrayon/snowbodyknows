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
        Schema::dropIfExists('parties_wishlists'); // debug
        Schema::create('parties_wishlists', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('party_id')->constrained('parties');
            $table->integer('party_id');
            // $table->foreignId('wishlist_id')->constrained('wishlists');
            $table->integer('wishlist_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties_wishlists');
    }
};
