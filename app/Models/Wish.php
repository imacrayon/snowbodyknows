<?php

namespace App\Models;

use Database\Factories\WishFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wish extends Model
{
    /** @use HasFactory<WishFactory> */
    use HasFactory, SoftDeletes;

    public function wishlist(): BelongsTo
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function granter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'granter_id')->withDefault();
    }

    public function granted(): bool
    {
        return ! is_null($this->granter_id);
    }

    public function grant(User $user): static
    {
        $this->granter()->associate($user);

        return $this;
    }

    public function ungrant(): static
    {
        $this->granter()->dissociate();

        return $this;
    }

    public function urlDomain(): string
    {
        $parts = explode('.', parse_url($this->url, PHP_URL_HOST) ?? '');

        return implode('.', array_slice($parts, -2));
    }
}
