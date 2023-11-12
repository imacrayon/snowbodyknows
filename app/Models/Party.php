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
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viewers()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
