<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Wish;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::unguard();
        Model::preventLazyLoading(! $this->app->isProduction());

        Relation::enforceMorphMap([
            'comment' => Comment::class,
            'wish' => Wish::class,
            'wishlist' => Wishlist::class,
            'user' => User::class,
        ]);
    }
}
