<?php

use App\Models\User;
use Illuminate\Support\Facades\URL;

test('unsubscribe page is displayed from a signed link', function () {
    $user = User::factory()->create();

    $response = $this->get(URL::signedRoute('unsubscribe.show', ['user' => $user, 'topic' => 'wishes']));

    $response->assertOk();
    $response->assertSee('new wishes');
    expect($user->refresh()->receives_wish_emails)->toBeTrue();
});

test('users can unsubscribe from a signed link', function (string $topic, string $preference) {
    $user = User::factory()->create();

    $response = $this->post(URL::signedRoute('unsubscribe.store', ['user' => $user, 'topic' => $topic]));

    $response->assertOk();
    $response->assertSee('You will no longer get emails');
    expect($user->refresh()->$preference)->toBeFalse();
})->with([
    'wishes' => ['wishes', 'receives_wish_emails'],
    'comments' => ['comments', 'receives_comment_emails'],
]);

test('users cannot unsubscribe without a valid signature', function () {
    $user = User::factory()->create();

    $response = $this->post(route('unsubscribe.store', ['user' => $user, 'topic' => 'wishes']));

    $response->assertForbidden();
    expect($user->refresh()->receives_wish_emails)->toBeTrue();
});
