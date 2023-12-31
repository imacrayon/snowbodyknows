<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function joinedWishlists()
    {
        return $this->belongsToMany(Wishlist::class)->withTimestamps();
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => "https://unavatar.io/{$attributes['email']}?".http_build_query([
                'fallback' => "https://ui-avatars.com/api/{$attributes['name']}/32/bae6fd/0c4a6e",
            ])
        )->shouldCache();
    }
}
