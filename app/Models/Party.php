<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Party extends Model
{
    use HasFactory, SoftDeletes;
    
    protected static $unguarded = true;
    
    protected $casts = [
        'start_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_date' => 'date',
        'end_time' => 'datetime:H:i'
    ];
    
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->invite_code = Str::uuid();
        });
        
        static::created(function ($model) {
            // assign self to party
            $model->participants()->syncWithoutDetaching($model->user);
            
            // auto create wishlist for self
            $wishlist = new Wishlist;
            $wishlist->name = __(':user’s Wishlist', ['user' => Str::before($model->user->name, ' ')]);
            $wishlist->user_id = $model->user->id;
            $wishlist->party_id = $model->id;
            $wishlist->save();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
