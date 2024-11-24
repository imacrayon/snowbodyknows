<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wish extends Model
{
    use HasFactory, SoftDeletes;

    protected static $unguarded = true;

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function granter()
    {
        return $this->belongsTo(User::class, 'granter_id')->withDefault();
    }

    public function granted()
    {
        return ! is_null($this->granter_id);
    }

    public function grant($user)
    {
        $this->granter()->associate($user);

        return $this;
    }

    public function ungrant()
    {
        return $this->granter()->dissociate();
    }

    public function urlDomain()
    {
        $parts = explode('.', parse_url($this->url, PHP_URL_HOST) ?? '');

        return implode('.', array_slice($parts, -2));
    }
}
