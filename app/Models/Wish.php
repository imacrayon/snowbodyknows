<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    use HasFactory;

    protected static $unguarded = true;

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function granter()
    {
        return $this->belongsTo(User::class, 'granter_id');
    }
}
