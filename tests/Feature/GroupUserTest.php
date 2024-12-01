<?php

use App\Models\Group;
use App\Models\User;
use App\Models\Wishlist;

test('guest can join a group', function () {
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->withWishlist($wishlist)->create();

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
    $group = Group::factory()->withWishlist($wishlist)->create();

    $response = $this->followingRedirects()->post(route('register', ['group' => (string) $group->invite_code]), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertOk();
    $response->assertViewIs('groups.show');
    $response->assertViewHas(['group' => $group]);
});

test('existing user is prompted to share wishlist with group after login', function () {
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->withWishlist($wishlist)->create();
    $user = Wishlist::factory()->create()->user;

    $response = $this->followingRedirects()->post(route('login', ['group' => (string) $group->invite_code]), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertOk();
    $response->assertViewIs('groups.wishlists.create');
    $response->assertViewHas(['group' => $group]);
});

test('existing user can share an existing wishlist with a group', function () {
    $group = Group::factory()->withWishlist(Wishlist::factory()->create())->create();
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('groups.wishlists.store', $group), [
        'wishlists' => [$wishlist->id],
    ]);

    $response->assertRedirect(route('groups.show', $group));
    expect($group->wishlists->contains($wishlist))->toBeTrue();
});

test('existing user can share a new wishlist with a group', function () {
    $group = Group::factory()->withWishlist(Wishlist::factory()->create())->create();
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('groups.wishlists.store', $group), [
        'wishlists' => [App\Http\Controllers\GroupWishlistController::NEW_WISHLIST],
    ]);

    $response->assertRedirect(route('groups.show', $group));
    expect($group->fresh()->wishlists)->toHaveCount(2);
    expect($wishlist->user->fresh()->wishlists)->toHaveCount(2);
});

test('user cannot share wishlist they do not own with a group', function () {
    $group = Group::factory()->withWishlist(Wishlist::factory()->create())->create();
    $wishlist = Wishlist::factory()->create();

    $this->actingAs(User::factory()->create());
    $response = $this->post(route('groups.wishlists.store', $group), [
        'wishlists' => [$wishlist->id],
    ]);

    $response->assertSessionHasErrors('wishlists.0');
});

test('users can join wishlists', function () {
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->withWishlist($wishlist)->create();

    $this->actingAs($user = User::factory()->create());

    $response = $this->post(route('groups.wishlists.store', $group), [
        'wishlists' => [App\Http\Controllers\GroupWishlistController::NEW_WISHLIST],
    ]);

    $response->assertRedirect(route('groups.show', $wishlist));
    expect($wishlist->viewers()->contains($user))->toBeTrue();
});

test('users can join multiple wishlists', function () {
    $wishlistA = Wishlist::factory()->create();
    $groupA = Group::factory()->withWishlist($wishlistA)->create();
    $wishlistB = Wishlist::factory()->create();
    $groupB = Group::factory()->withWishlist($wishlistB)->create();

    $this->actingAs($user = User::factory()->create());

    $this->post(route('groups.wishlists.store', $groupA), [
        'wishlists' => [App\Http\Controllers\GroupWishlistController::NEW_WISHLIST],
    ]);
    $this->post(route('groups.wishlists.store', $groupB), [
        'wishlists' => [App\Http\Controllers\GroupWishlistController::NEW_WISHLIST],
    ]);

    expect($wishlistA->viewers()->contains($user))->toBeTrue();
    expect($wishlistB->viewers()->contains($user))->toBeTrue();
});

test('group viewers can leave group', function () {
    $viewer = User::factory()->create();
    $wishlist = Wishlist::factory()->create();
    $group = Group::factory()->withWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($viewer);

    $response = $this->delete(route('groups.users.destroy', [$group, $viewer]));

    $response->assertRedirect(route('app'));
    expect($wishlist->viewers()->contains($viewer))->toBeFalse();
});

test('wishlists are purged when user leaves group', function () {
    $wishlistA = Wishlist::factory()->create();
    $wishlistB = Wishlist::factory()->for($wishlistA->user)->create();
    $group = Group::factory()
        ->withWishlist(Wishlist::factory()->create())
        ->withWishlist($wishlistA)
        ->hasAttached($wishlistB)
        ->create();

    expect($group->wishlists)->toHaveCount(3);

    $this->actingAs($wishlistA->user);
    $this->delete(route('groups.users.destroy', [$group, $wishlistA->user]));

    $group->refresh();
    expect($group->users->contains($wishlistA->user))->toBeFalse();
    expect($group->wishlists->contains($wishlistA))->toBeFalse();
    expect($group->wishlists->contains($wishlistB))->toBeFalse();
    expect($group->wishlists)->toHaveCount(1);
});

test('group viewers cannot remove another member from group', function () {
    $viewer = User::factory()->create();
    $wishlist = Wishlist::factory()->create();
    Group::factory()->withWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($wishlist->user);

    $this->delete(route('groups.users.destroy', [$wishlist, $viewer]))->assertForbidden();
});
