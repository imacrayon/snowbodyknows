<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'comment' => 'App\Models\Comment',
            'wish' => 'App\Models\Wish',
            'wishlist' => 'App\Models\Wishlist',
            'user' => 'App\Models\User',
        ]);
    }
}
