<?php

use App\Http\Controllers\GroupController;
use App\Models\Group;
use App\Models\User;
use App\Models\Wishlist;

test('users can view groups to share their wishlist with', function () {
    $wishlist = Wishlist::factory()->create();
    $yourGroup = Group::factory()->withUser($wishlist->user)->create();
    $otherGroup = Group::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->get(route('groups.create', $wishlist));

    $response->assertOk();
    $response->assertSee($yourGroup->name);
    $response->assertDontSee($otherGroup->name);
});

test('users cannot view groups to share another user\'s wishlist with', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs(User::factory()->create());
    $response = $this->get(route('groups.create', $wishlist));

    $response->assertForbidden();
});

test('users can create wishlist group', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('groups.store', $wishlist), [
        'groups' => [GroupController::NEW_GROUP],
    ]);

    $group = Group::first();
    $response->assertRedirect(route('groups.show', $group));
    expect($group->wishlists->contains($wishlist))->toBeTrue();
    expect($group->users->contains($wishlist->user))->toBeTrue();
});

test('users can share wishlist with exactly the selected groups', function () {
    $wishlist = Wishlist::factory()->create();
    $sharedGroup = Group::factory()->withWishlist($wishlist)->create();
    $selectedGroup = Group::factory()->withUser($wishlist->user)->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('groups.store', $wishlist), [
        'groups' => [$selectedGroup->id],
    ]);

    $response->assertRedirect(route('wishlists.show', $wishlist));
    expect($wishlist->refresh()->groups->modelKeys())->toBe([$selectedGroup->id]);
});

test('users cannot share wishlist with groups they do not belong to', function () {
    $wishlist = Wishlist::factory()->create();
    $otherGroup = Group::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('groups.store', $wishlist), [
        'groups' => [$otherGroup->id],
    ]);

    $response->assertSessionHasErrors('groups.0');
    expect($wishlist->refresh()->groups)->toBeEmpty();
});

test('users cannot share another user\'s wishlist', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs(User::factory()->create());
    $response = $this->post(route('groups.store', $wishlist), [
        'groups' => [GroupController::NEW_GROUP],
    ]);

    $response->assertForbidden();
    expect(Group::count())->toBe(0);
});
