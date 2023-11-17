<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()->joinedParties->isNotEmpty() || $request->user()->joinedWishlists->isNotEmpty() || $request->user()->wishlists->count() > 1) {
            return to_route('wishlists.index');
        }

        return to_route('wishlists.show', $request->user()->wishlists->first());
    }
}
