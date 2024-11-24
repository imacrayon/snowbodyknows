<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.register', [
            'group' => $request->query('group'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $wishlist = $user->wishlists()->create([
            'name' => __(':user’s Wishlist', ['user' => Str::before($user->name, ' ')]),
        ]);

        if (session('wishlist')) {
            foreach (session('wishlist')['wishes'] as $wish) {
                $wishlist->wishes()->create([
                    'name' => $wish['name'],
                    'description' => $wish['description'],
                    'url' => $wish['url'],
                ]);
            }
            session()->remove('wishlist');
        }

        event(new Registered($user));

        Auth::login($user);

        if ($code = $request->query('group')) {
            if ($group = Group::findByInviteCode($code)) {
                $group->join($user, $wishlist->id);

                return to_route('groups.show', $group);
            }
        }

        return redirect()->intended(route('app', absolute: false));
    }
}
