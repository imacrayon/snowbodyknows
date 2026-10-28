<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Wishlist;
use App\Notifications\WishlistCommentCreatedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class WishlistCommentController extends Controller
{
    public function store(Request $request, Wishlist $wishlist): RedirectResponse
    {
        $validated = $request->validate(['comment' => ['required', 'string', 'max:5000']]);

        $comment = $wishlist->addComment($validated['comment'], $request->user());

        $watchers = $wishlist->viewers()->reject(fn ($user) => $user->is($request->user()));

        Notification::send($watchers, new WishlistCommentCreatedNotification($comment));

        return to_route('wishlists.show', $wishlist);
    }

    public function edit(Wishlist $wishlist, Comment $comment): View
    {
        return view('wishlists.comments.edit', [
            'wishlist' => $wishlist,
            'comment' => $comment,
        ]);
    }

    public function update(Request $request, Wishlist $wishlist, Comment $comment): RedirectResponse
    {
        $validated = $request->validate(['comment' => ['required', 'string', 'max:5000']]);

        $comment->update(['content' => $validated['comment']]);

        return to_route('wishlists.show', $wishlist);
    }

    public function destroy(Wishlist $wishlist, Comment $comment): RedirectResponse
    {
        $comment->delete();

        return to_route('wishlists.show', $wishlist);
    }
}
