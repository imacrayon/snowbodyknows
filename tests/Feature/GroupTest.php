<?php

use App\Models\Group;
use App\Models\User;
use App\Models\Wishlist;

test('users can create wishlist group', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);

    $response = $this->post(route('groups.store', $wishlist));

    $group = Group::first();
    $response->assertRedirect(route('groups.show', $wishlist));
    expect($group->wishlists->contains($wishlist))->toBeTrue();
});

test('guest can join a group', function () {
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->forWishlist($wishlist)->create();

    $response = $this->get(route('join', $group));

    $response->assertSee(route('login', ['group' => $group->invite_code]));
    $response->assertSee(route('register', ['group' => $group->invite_code]));

    $response = $this->get(route('login', ['group' => $group->invite_code]));
    $response->assertSee(route('login', ['group' => $group->invite_code]));

    $response = $this->get(route('register', ['group' => $group->invite_code]));
    $response->assertSee(route('register', ['group' => $group->invite_code]));
});

test('new user is added to group after registration', function () {
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->forWishlist($wishlist)->create();

    $response = $this->followingRedirects()->post(route('register', ['group' => (string) $group->invite_code]), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertViewIs('groups.show');
    $response->assertViewHas(['group' => $group]);
});

test('existing user is prompted to share wishlist with group after login', function () {
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->forWishlist($wishlist)->create();
    $user = User::factory()->create();

    $response = $this->followingRedirects()->post(route('login', ['group' => (string) $group->invite_code]), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertViewIs('groups.users.create');
    $response->assertViewHas(['group' => $group]);
});

test('existing user can share an existing wishlist with a group', function () {
    $group = Group::factory()->forWishlist(Wishlist::factory()->create())->create();
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('groups.users.store', $group), [
        'wishlist_id' => $wishlist->id,
    ]);

    $response->assertRedirect(route('groups.show', $group));
    expect($group->wishlists->contains($wishlist))->toBeTrue();
});

test('existing user can share a new wishlist with a group', function () {
    $group = Group::factory()->forWishlist(Wishlist::factory()->create())->create();
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('groups.users.store', $group), [
        'wishlist_id' => '',
    ]);

    $response->assertRedirect(route('groups.show', $group));
    expect($group->wishlists)->toHaveCount(2);
    expect($wishlist->user->fresh()->wishlists)->toHaveCount(2);
});

test('user cannot share wishlist they do not own with a group', function () {
    $group = Group::factory()->forWishlist(Wishlist::factory()->create())->create();
    $wishlist = Wishlist::factory()->create();

    $this->actingAs(User::factory()->create());
    $response = $this->post(route('groups.users.store', $group), [
        'wishlist_id' => $wishlist->id,
    ]);

    $response->assertSessionHasErrors('wishlist_id');
});
