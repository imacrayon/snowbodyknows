<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_wishlist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('wishlist_id')->constrained('wishlists');
            $table->timestamps();
        });

        DB::table('group_wishlist')->insertUsing([
            'group_id', 'wishlist_id',
        ], DB::table('group_user')->select(
            'group_id', 'wishlist_id'
        ));

        Schema::table('group_user', function (Blueprint $table) {
            $table->dropForeign(['wishlist_id']);
            $table->dropColumn('wishlist_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_wishlist');
    }
};
