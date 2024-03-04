<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Wishlist;
use App\Notifications\WishlistCommentCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class WishlistCommentController extends Controller
{
    public function show(Wishlist $wishlist, Comment $comment)
    {
        return view('components.comment', ['wishlist' => $wishlist, 'comment' => $comment ]);
    }

    public function edit(Wishlist $wishlist, Comment $comment)
    {

        return view('components.comment-form', [
            'comment' => $comment,
            'wishlist' => $wishlist,
            'action' => route('wishlists.comments.update', [
                'wishlist' => $wishlist->id,
                'comment' => $comment->id,
            ]),
            'method' => 'patch',
            'anonymous' => false
        ]);
    }

    public function store(Request $request, Wishlist $wishlist)
    {
        $request->validate(['comment' => ['required', 'string', 'max:5000']]);

        $comment = $wishlist->addComment($request->comment, $request->user());

        $watchers = $wishlist->viewers->push($wishlist->user)->reject(fn ($user) => $user->is($request->user()) || !$user->settings['notification']['wishlist-comment-created']);

        Notification::send($watchers, new WishlistCommentCreatedNotification($comment));

        return to_route('wishlists.show', $wishlist);
    }

    public function update(Request $request, Wishlist $wishlist, Comment $comment)
    {
        $request->validate(['comment' => ['required', 'string', 'max:5000']]);

        $comment->update(['content' => $request->comment]);

        return to_route('wishlists.show', $wishlist);
    }

    public function destroy(Wishlist $wishlist, Comment $comment)
    {
        $comment->delete();

        return to_route('wishlists.show', $wishlist);
    }
}
