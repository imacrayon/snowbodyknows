<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

test('logging in records when the user last logged in', function () {
    $this->travelTo('2026-12-02 09:00:00');
    $user = User::factory()->create();

    $this->post(route('login'), ['email' => $user->email, 'password' => 'password']);

    expect($user->fresh()->last_login_at->toDateTimeString())->toBe('2026-12-02 09:00:00');
});

test('returning with a remember me cookie records when the user last logged in', function () {
    $this->travelTo('2026-12-02 09:00:00');
    $user = User::factory()->create();
    $recallerName = Auth::guard()->getRecallerName();
    $recaller = $this->post(route('login'), ['email' => $user->email, 'password' => 'password', 'remember' => 'on'])
        ->getCookie($recallerName)
        ->getValue();
    Auth::forgetGuards();
    $this->flushSession();
    $this->travelTo('2026-12-20 18:00:00');

    $response = $this->withCookie($recallerName, $recaller)->get(route('wishlists.index'));

    $response->assertOk();
    $this->assertAuthenticatedAs($user);
    expect($user->fresh()->last_login_at->toDateTimeString())->toBe('2026-12-20 18:00:00');
});
