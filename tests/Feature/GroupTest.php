<?php

use App\Models\Group;
use App\Models\Wishlist;

test('users can create wishlist group', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);

    $response = $this->post(route('groups.store', $wishlist));

    $group = Group::first();
    $response->assertRedirect(route('groups.show', $wishlist));
    expect($group->wishlists->contains($wishlist))->toBeTrue();
});
