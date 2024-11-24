<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use App\Models\Wishlist;
use App\Notifications\WishCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class WishController extends Controller
{
    public function create(Wishlist $wishlist)
    {
        return view('wishes.create', [
            'wishlist' => $wishlist,
            'wish' => new Wish,
        ]);
    }

    public function store(Request $request, Wishlist $wishlist)
    {
        $wish = $wishlist->wishes()->create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url:http,https', 'max:2000'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]));

        $watchers = $wishlist->members()->reject(fn ($user) => $user->is($wishlist->user));

        Notification::send($watchers, new WishCreatedNotification($wish));

        return to_route('wishlists.show', $wishlist);
    }

    public function edit(Wishlist $wishlist, Wish $wish)
    {
        return view('wishes.edit', [
            'wishlist' => $wishlist,
            'wish' => $wish,
        ]);

    }

    public function update(Request $request, Wishlist $wishlist, Wish $wish)
    {
        $wish->update($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url:http,https', 'max:2000'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]));

        return to_route('wishlists.show', $wishlist);
    }

    public function destroy(Wishlist $wishlist, Wish $wish)
    {
        $wish->delete();

        return to_route('wishlists.show', $wishlist);
    }
}
