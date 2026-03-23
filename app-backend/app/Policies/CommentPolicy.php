<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine if the user can delete the comment.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->is_admin;
    }

    /**
     * Determine if the user can approve the comment.
     */
    public function approve(User $user, Comment $comment): bool
    {
        return $user->is_admin;
    }
}
