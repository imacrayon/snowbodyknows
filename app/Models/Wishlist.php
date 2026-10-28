<?php

namespace App\Models;

use Database\Factories\WishlistFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    /** @use HasFactory<WishlistFactory> */
    use Commentable, HasFactory, SoftDeletes;

    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_wishlist')->orderBy('name');
    }

    public function viewers(): Collection
    {
        // Reduce, not flatMap, so that we return an Eloquent\Collection.
        return $this->loadMissing('groups.users')->groups->reduce(function ($members, $group) {
            return $members->merge($group->users);
        }, new Collection);
    }
}
