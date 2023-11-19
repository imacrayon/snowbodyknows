<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Comment $comment): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Comment $comment): bool
    {
        return $comment->user->is($user);
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $this->update($user, $comment) || $comment->commentable->user->is($user);
    }

    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
