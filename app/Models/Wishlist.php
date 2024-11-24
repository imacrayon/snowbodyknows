<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    use Commentable, HasFactory, SoftDeletes;

    protected static $unguarded = true;

    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user');
    }

    public function members()
    {
        // Use reduce instead of flatMap so that we can return an Eloquent\Collection
        return $this->loadMissing('groups.users')->groups->reduce(function ($members, $group) {
            return $members->merge($group->users);
        }, new Collection);
    }
}
