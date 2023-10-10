<?php

use App\Models\User;
use App\Models\Wishlist;

test('users can join wishlists via invite link', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($user = User::factory()->create());

    $response = $this->post(route('wishlists.viewers.store', $wishlist));

    $response->assertRedirect(route('wishlists.show', $wishlist));
    expect($wishlist->viewers->contains($user))->toBeTrue();
});

test('users can join multiple wishlists', function () {
    $wishlistA = Wishlist::factory()->create();
    $wishlistB = Wishlist::factory()->create();

    $this->actingAs($user = User::factory()->create());

    $this->post(route('wishlists.viewers.store', $wishlistA));
    $this->post(route('wishlists.viewers.store', $wishlistB));

    expect($user->joinedWishlists)->toHaveCount(2);
});

test('users can leave wishlists', function () {
    $user = User::factory()->create();
    $wishlist = Wishlist::factory()->create();
    $wishlist->viewers()->attach($user);

    $this->actingAs($user);

    $response = $this->delete(route('wishlists.viewers.destroy', [$wishlist, $user]));

    $response->assertRedirect(route('app'));
    expect($wishlist->viewers)->toBeEmpty();
});

test('owners can kick users from their wishlist', function () {
    $viewer = User::factory()->create();
    $wishlist = Wishlist::factory()->create();
    $wishlist->viewers()->attach($viewer);

    $this->actingAs($wishlist->user);

    $response = $this->delete(route('wishlists.viewers.destroy', [$wishlist, $viewer]));

    $response->assertRedirect(route('wishlists.show', $wishlist));
    expect($wishlist->viewers)->toBeEmpty();
});

test('users cannot kick other viewers from others’ wishlist', function () {
    $viewer = User::factory()->create();
    $wishlist = Wishlist::factory()->create();
    $wishlist->viewers()->attach($viewer);

    $this->actingAs(User::factory()->create());

    $this->delete(route('wishlists.viewers.destroy', [$wishlist, $viewer]))->assertForbidden();
});

test('viewers cannot kick other viewers from others’ wishlist', function () {
    $viewerA = User::factory()->create();
    $wishlist = Wishlist::factory()->create();
    $wishlist->viewers()->attach($viewerA);
    $viewerB = User::factory()->create();
    $wishlist->viewers()->attach($viewerB);

    $this->actingAs($viewerA);

    $this->delete(route('wishlists.viewers.destroy', [$wishlist, $viewerB]))->assertForbidden();
});
