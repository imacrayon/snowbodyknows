<?php

use App\Models\Group;
use App\Models\Wishlist;

test('user can edit wishlists shared with group', function () {
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->withWishlist($wishlist)->create();
    $anotherWishlist = Wishlist::factory()->for($wishlist->user)->create();

    $this->actingAs($wishlist->user);
    $response = $this->get(route('groups.wishlists.edit', $group));

    $response->assertOk();
    $response->assertSee($wishlist->name);
    $response->assertSee($anotherWishlist->name);
});

test('user can change wishlists shared with group', function () {
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()
        ->withWishlist($wishlist)
        ->withWishlist(Wishlist::factory()->create())
        ->create();
    $anotherWishlist = Wishlist::factory()->for($wishlist->user)->create();

    expect($group->wishlists)->toHaveCount(2);

    $this->actingAs($wishlist->user);
    $response = $this->patch(route('groups.wishlists.update', $group), [
        'wishlists' => [$anotherWishlist->id],
    ]);

    $group->refresh();
    $response->assertRedirect(route('groups.show', $group));
    expect($group->wishlists->contains($wishlist))->toBeFalse();
    expect($group->wishlists->contains($anotherWishlist))->toBeTrue();
    expect($group->wishlists)->toHaveCount(2);
});

test('user can remove wishlists shared with group', function () {
    $wishlist = Wishlist::factory()->create();
    $anotherWishlist = Wishlist::factory()->for($wishlist->user)->create();
    $group = Group::factory()
        ->withWishlist($wishlist)
        ->withWishlist($anotherWishlist)
        ->create();

    expect($group->wishlists)->toHaveCount(2);

    $this->actingAs($wishlist->user);
    $response = $this->patch(route('groups.wishlists.update', $group), [
        'wishlists' => [$anotherWishlist->id],
    ]);

    $group->refresh();
    $response->assertRedirect(route('groups.show', $group));
    expect($group->wishlists->contains($wishlist))->toBeFalse();
    expect($group->wishlists->contains($anotherWishlist))->toBeTrue();
    expect($group->wishlists)->toHaveCount(1);
});
