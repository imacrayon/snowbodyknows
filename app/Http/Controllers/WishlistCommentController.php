<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Wishlist;
use App\Notifications\WishlistCommentCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class WishlistCommentController extends Controller
{
    public function store(Request $request, Wishlist $wishlist)
    {
        $request->validate(['comment' => ['required', 'string', 'max:5000']]);

        $comment = $wishlist->addComment($request->comment, $request->user());

        $watchers = $wishlist->members()->reject(fn ($user) => $user->is($request->user()));

        Notification::send($watchers, new WishlistCommentCreatedNotification($comment));

        return to_route('wishlists.show', $wishlist);
    }

    public function update(Request $request, Wishlist $wishlist, Comment $comment)
    {
        $request->validate(['content' => ['required', 'string', 'max:5000']]);

        $comment->update(['content' => $request->comment]);

        return to_route('wishlists.show', $wishlist);
    }

    public function destroy(Wishlist $wishlist, Comment $comment)
    {
        $comment->delete();

        return to_route('wishlists.show', $wishlist);
    }
}
