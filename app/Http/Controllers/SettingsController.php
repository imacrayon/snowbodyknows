<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    /** 
     * Update user's settings 
    */
    public function update(Request $request): RedirectResponse
    {
        $settings = $request->user()->settings;
        $settings['notification']['wishlist-comment-created'] = (bool) $request->request->get('notification-wishlist-comment-created');
        $settings['notification']['wish-created'] = (bool) $request->request->get('notification-wish-created'); 
        $request->user()->settings = $settings;
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'settings-updated');
    }
}
