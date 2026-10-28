<?php

namespace App\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    /** @use HasFactory<CommentFactory> */
    use Commentable, HasFactory;

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function isAnonymous(): bool
    {
        return $this->user->isNot($this->commentable->user);
    }

    public function isEdited(): bool
    {
        return $this->updated_at->gt($this->created_at);
    }
}
