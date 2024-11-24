<?php

use App\Models\Group;
use App\Models\User;
use App\Models\Wishlist;

test('users can join wishlists', function () {
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->forWishlist($wishlist)->create();

    $this->actingAs($user = User::factory()->create());

    $response = $this->post(route('groups.users.store', $group));

    $response->assertRedirect(route('groups.show', $wishlist));
    expect($wishlist->members()->contains($user))->toBeTrue();
});

test('users can join multiple wishlists', function () {
    $wishlistA = Wishlist::factory()->create();
    $groupA = Group::factory()->forWishlist($wishlistA)->create();
    $wishlistB = Wishlist::factory()->create();
    $groupB = Group::factory()->forWishlist($wishlistB)->create();

    $this->actingAs($user = User::factory()->create());

    $this->post(route('groups.users.store', $groupA));
    $this->post(route('groups.users.store', $groupB));

    expect($wishlistA->members()->contains($user))->toBeTrue();
    expect($wishlistB->members()->contains($user))->toBeTrue();
});

test('users can leave wishlists', function () {
    $user = User::factory()->create();
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->forWishlist($wishlist)->withUser($user)->create();

    $this->actingAs($user);

    $response = $this->delete(route('groups.users.destroy', [$group, $user]));

    $response->assertRedirect(route('app'));
    expect($wishlist->members()->contains($user))->toBeFalse();
});

test('group members can leave group', function () {
    $viewer = User::factory()->create();
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->forWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($viewer);

    $response = $this->delete(route('groups.users.destroy', [$group, $viewer]));

    $response->assertRedirect(route('app'));
    expect($wishlist->members()->contains($viewer))->toBeFalse();
});

test('group members cannot remove another member from group', function () {
    $viewer = User::factory()->create();
    $wishlist = Wishlist::factory()->create();
    Group::factory()->forWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($wishlist->user);

    $this->delete(route('groups.users.destroy', [$wishlist, $viewer]))->assertForbidden();
});
