<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Commentable
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function addComment(string $content, ?Model $author = null): Comment
    {
        return $this->comments()->create([
            'content' => $content,
            'user_id' => $author?->getKey(),
        ]);
    }
}
