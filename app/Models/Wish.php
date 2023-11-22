<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wish extends Model
{
    use HasFactory, SoftDeletes;

    protected static $unguarded = true;

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($params = config('affiliates')[$model->urlDomain()] ?? null) {
                $model->url = $model->mergeIntoUrl($params);
            }
        });
    }

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

    public function mergeIntoUrl($params = [])
    {
        $parts = parse_url($this->url);

        $existing = [];
        if (isset($parts['query'])) {
            parse_str($parts['query'], $existing);
        }

        $path = $parts['path'] ?? '';
        $url = "{$parts['scheme']}://{$parts['host']}{$path}";

        if ($query = http_build_query(array_merge($existing, $params))) {
            $url .= '?'.$query;
        }

        if (isset($parts['fragment'])) {
            $url .= '#'.$parts['fragment'];
        }

        return $url;
    }
}
