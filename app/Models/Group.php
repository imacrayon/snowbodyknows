<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Group extends Model
{
    use HasFactory;

    protected static $unguarded = true;

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->invite_code = Str::uuid();
        });
    }

    public static function findByInviteCode($code)
    {
        return static::where('invite_code', $code)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('wishlist_id')
            ->withTimestamps()
            ->orderBy('name');
    }

    public function wishlists()
    {
        return $this->belongsToMany(Wishlist::class, 'group_user')
            ->withPivot('user_id')
            ->withTimestamps();
    }

    public function join($user, $wishlistId)
    {
        return $this->users()->syncWithoutDetaching([
            $user->id => ['wishlist_id' => $wishlistId],
        ]);
    }
}
