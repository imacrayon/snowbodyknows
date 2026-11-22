<?php

namespace App\Http\Controllers;

use App\Http\Requests\WishRequest;
use App\Jobs\NotifyViewersOfNewWishes;
use App\Models\Wish;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishController extends Controller
{
    public function create(Wishlist $wishlist): View
    {
        return view('wishes.create', [
            'wishlist' => $wishlist,
            'wish' => new Wish,
        ]);
    }

    public function store(WishRequest $request, Wishlist $wishlist): RedirectResponse
    {
        $wishlist->wishes()->create($request->validated() + ['notify_viewers' => true]);

        NotifyViewersOfNewWishes::dispatch($wishlist);

        return to_route('wishlists.show', $wishlist);
    }

    public function edit(Wishlist $wishlist, Wish $wish): View
    {
        return view('wishes.edit', [
            'wishlist' => $wishlist,
            'wish' => $wish,
        ]);
    }

    public function update(WishRequest $request, Wishlist $wishlist, Wish $wish): RedirectResponse
    {
        $wish->update($request->validated());

        return to_route('wishlists.show', $wishlist);
    }

    public function destroy(Wishlist $wishlist, Wish $wish): RedirectResponse
    {
        $wish->delete();

        return to_route('wishlists.show', $wishlist);
    }
}
