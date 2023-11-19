<?php

namespace App\Models;

trait Commentable
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function addComment($content, $author = null)
    {
        return $this->comments()->create([
            'content' => $content,
            'user_id' => $author->getKey(),
        ]);
    }
}
