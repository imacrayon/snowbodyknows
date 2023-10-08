<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Wishlist extends Model
{
    use HasFactory, SoftDeletes;

    protected static $unguarded = true;

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->invite_code = Str::uuid();
        });
    }

    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viewers()
    {
        return $this->belongsToMany(User::class);
    }
}
