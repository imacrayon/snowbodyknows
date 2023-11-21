<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wishlist;
use App\Providers\RouteServiceProvider;
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
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        return view('auth.register', [
            'wishlist' => $request->query('wishlist'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $newWishlist = $user->wishlists()->create([
            'name' => __(':user’s Wishlist', ['user' => Str::before($user->name, ' ')]),
        ]);

        if (session('wishlist')) {
            foreach (session('wishlist')['wishes'] as $wish) {
                $newWishlist->wishes()->create([
                    'name' => $wish['name'],
                    'description' => $wish['description'],
                    'url' => $wish['url']
                ]);
            }
            session()->remove('wishlist');
        }

        event(new Registered($user));

        Auth::login($user);

        $invitecode = $request->query('wishlist');
        if($wishlist = Wishlist::findByInviteCode($invitecode)){  
            $wishlist->viewers()->syncWithoutDetaching($user);   
            return to_route('wishlists.show', $wishlist);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
