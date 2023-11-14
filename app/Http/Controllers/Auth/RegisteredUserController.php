<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Party;
use App\Models\User;
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
            'party' => $request->query('party'),
            'adventure' => $request->query('adventure')
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

        if ($request->query('adventure') && $request->query('adventure') == 'create_party') {
            $p = new Party;
            $p->name = $request->name."'s Party";
            $p->user_id = $user->id;
            $p->save();
            $user->wishlists()->create([
                'name' => __(':user’s Wishlist for :party', ['user' => Str::before($user->name, ' '), 'party' => $p->name]),
                'party_id' => $p->id,
            ]);
        }

        if ($request->query('party')) {
            $p = Party::where('invite_code', $request->query('party'))->firstOrFail();
            $user->wishlists()->create([
                'name' => __(':user’s Wishlist for :party', ['user' => Str::before($user->name, ' '), 'party' => $p->name]),
                'party_id' => $p->id,
            ]);
        }
        else {
            $user->wishlists()->create([
                'name' => __(':user’s Wishlist', ['user' => Str::before($user->name, ' ')]),
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        if ($request->query('adventure') && $request->query('adventure') == 'create_party') {
            return to_route('parties.index', $p);
        }

        if ($wishlist = $request->query('wishlist')) {
            return to_route('wishlists.viewers.create', $wishlist);
        }

        if ($party = $request->query('party')) {
            return to_route('parties.participants.create', $party);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
