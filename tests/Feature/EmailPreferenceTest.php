<?php

use App\Models\User;

test('users can turn off email notifications', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    $response = $this->patch(route('profile.email-preferences.update'));

    $response->assertRedirectToRoute('profile.edit');
    expect($user->refresh())
        ->receives_wish_emails->toBeFalse()
        ->receives_comment_emails->toBeFalse();
});

test('users can turn on email notifications', function () {
    $user = User::factory()->create([
        'receives_wish_emails' => false,
        'receives_comment_emails' => false,
    ]);

    $this->actingAs($user);
    $response = $this->patch(route('profile.email-preferences.update'), [
        'receives_wish_emails' => '1',
        'receives_comment_emails' => '1',
    ]);

    $response->assertRedirectToRoute('profile.edit');
    expect($user->refresh())
        ->receives_wish_emails->toBeTrue()
        ->receives_comment_emails->toBeTrue();
});

test('guests cannot update email preferences', function () {
    $response = $this->patch(route('profile.email-preferences.update'));

    $response->assertRedirect(route('login'));
});
