<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;

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
        
        // auto create wishlist for self
        $wishlist = new Wishlist;
        $wishlist->name = $request->user()->name."'s Wishlist for Party ".$party->name;
        $wishlist->user_id = $request->user()->id;
        $wishlist->party_id = $party->id;
        $wishlist->save();

        return to_route('parties.show', $party);
    }
    
    public function destroy(Request $request, Party $party, User $user)
    {
        dd('parties destroy');
        // $party->participants()->detach($user);

        // if ($request->user()->is($user)) {
        //     return to_route('app');
        // }

        // return to_route('parties.show', $party);
    }
}
