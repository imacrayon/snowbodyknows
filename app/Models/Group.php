<?php

namespace App\Models;

use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Group extends Model
{
    /** @use HasFactory<GroupFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (self $group): void {
            $group->invite_code = Str::uuid();
        });
    }

    public static function findByInviteCode(string $code): ?self
    {
        return static::where('invite_code', $code)->first();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps()->orderBy('name');
    }

    public function wishlists(): BelongsToMany
    {
        return $this->belongsToMany(Wishlist::class)->withTimestamps()->orderBy('name');
    }
}
