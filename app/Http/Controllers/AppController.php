<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        if ($request->user()->groups->count() === 1) {
            return to_route('groups.show', $request->user()->groups->first());
        }

        return to_route('wishlists.index');
    }
}
