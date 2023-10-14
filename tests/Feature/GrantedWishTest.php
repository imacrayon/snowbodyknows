<?php

use App\Models\User;
use App\Models\Wish;

test('wishlist owner cannot grant wishes', function () {
    $wish = Wish::factory()->create();

    $this->actingAs($wish->wishlist->user);

    $this->post(route('wishes.grants.store', $wish), [])->assertForbidden();
});

test('wishlist owner cannot ungrant wishes', function () {
    $wish = Wish::factory()->granted()->create();

    $this->actingAs($wish->wishlist->user);

    $this->post(route('wishes.grants.destroy', $wish), [])->assertForbidden();
});

test('wishlist viewer can grant wishes', function () {
    $wish = Wish::factory()->create();
    $viewer = User::factory()->create();
    $wish->wishlist->viewers()->attach($viewer);

    $this->actingAs($viewer);

    $response = $this->post(route('wishes.grants.store', $wish));

    $response->assertRedirect();
    expect($wish->fresh()->granted())->toBeTrue();
});

test('wishlist viewer can ungrant their granted wishes', function () {
    $viewer = User::factory()->create();
    $wish = Wish::factory()->for($viewer, 'granter')->create();
    $wish->wishlist->viewers()->attach($viewer);

    expect($wish->granted())->toBeTrue();

    $this->actingAs($viewer);

    $response = $this->delete(route('wishes.grants.destroy', $wish));

    $response->assertRedirect();
    expect($wish->fresh()->granted())->toBeFalse();
});

test('wishlist viewer cannot grant others’ granted wishes', function () {
    $wish = Wish::factory()->granted()->create();
    $viewer = User::factory()->create();
    $wish->wishlist->viewers()->attach($viewer);

    $this->actingAs($viewer);

    $this->post(route('wishes.grants.store', $wish))->assertForbidden();
});

test('wishlist viewer cannot ungrant others’ granted wishes', function () {
    $viewerA = User::factory()->create();
    $viewerB = User::factory()->create();
    $wish = Wish::factory()->for($viewerB, 'granter')->create();
    $wish->wishlist->viewers()->attach($viewerA);

    expect($wish->granted())->toBeTrue();

    $this->actingAs($viewerA);

    $this->post(route('wishes.grants.destroy', $wish))->assertForbidden();
});
