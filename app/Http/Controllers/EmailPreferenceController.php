<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailPreferenceController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->user()->update([
            'receives_wish_emails' => $request->boolean('receives_wish_emails'),
            'receives_comment_emails' => $request->boolean('receives_comment_emails'),
        ]);

        return to_route('profile.edit')->with('status', 'email-preferences-updated');
    }
}
