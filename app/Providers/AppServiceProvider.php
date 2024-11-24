<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());

        Relation::enforceMorphMap([
            'comment' => 'App\Models\Comment',
            'wish' => 'App\Models\Wish',
            'wishlist' => 'App\Models\Wishlist',
            'user' => 'App\Models\User',
        ]);
    }
}
