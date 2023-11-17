<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartyParticipantController extends Controller
{
    public function create(Request $request, Party $party)
    {
        if (is_null($request->user())) {
            return to_route('login', ['party' => $party->invite_code]);
        }

        return view('parties.participants.create', [
            'party' => $party,
        ]);
    }
    
    public function store(Request $request, Party $party)
    {
        // assign self to party
        $party->participants()->syncWithoutDetaching($request->user());
        
        // auto create wishlist for self if one doesn't exist
        $wishlist_party = Wishlist::where('party_id', $party->id)->where('user_id', $request->user()->id)->first();
        if (!$wishlist_party) {
            $wishlist = new Wishlist;
            $wishlist->name = __(':user’s Wishlist', ['user' => Str::before($request->user()->name, ' ')]);
            $wishlist->user_id = $request->user()->id;
            $wishlist->party_id = $party->id;
            $wishlist->save();
        }

        return to_route('parties.show', $party);
    }
    
    public function destroy(Request $request, Party $party, User $user)
    {
        $party->participants()->detach($user);

        // cascade remove party_id from user's wishlists
        $wishlists = Wishlist::where('user_id', $user->id)->where('party_id', $party->id)->get();
        foreach ($wishlists as $wishlist) {
            $wishlist->party_id = null;
            $wishlist->save();
        }
        
        if ($request->user()->is($user)) {
            return to_route('app');
        }

        return to_route('parties.show', $party);
    }
}
