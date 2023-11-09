<?php

use App\Models\User;
use App\Models\Wishlist;

test('default wishlist is created when user registers', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect();
    $user = User::first();
    expect($user->wishlists)->not->toBeEmpty()
        ->first()->name->toBe('Test’s Wishlist');
});

test('users can view their wishlists', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->get(route('wishlists.show', $wishlist));

    $response->assertOk();
    $response->assertSee($wishlist->name);
});

test('users cannot view others’ wishlists', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs(User::factory()->create());
    $this->get(route('wishlists.show', $wishlist))->assertForbidden();
});

test('users can create wishlists', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    $response = $this->post(route('wishlists.store'), [
        'name' => 'New Wishlist',
    ]);

    $wishlist = Wishlist::first();
    $response->assertRedirectToRoute('wishlists.show', $wishlist);
    expect($wishlist->name)->toBe('New Wishlist');
});

test('users can change their wishlist name', function () {
    $wishlist = Wishlist::factory()->create([
        'name' => 'Old Name',
    ]);

    $this->actingAs($wishlist->user);
    $response = $this->patch(route('wishlists.update', $wishlist), [
        'name' => 'New Name',
    ]);

    $response->assertRedirectToRoute('wishlists.show', $wishlist);
    expect($wishlist->fresh()->name)->toBe('New Name');
});

test('users cannot change others’ wishlists', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs(User::factory()->create());
    $this->patch(route('wishlists.update', $wishlist))->assertForbidden();
});

test('users cannot delete their default wishlist', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $this->delete(route('wishlists.destroy', $wishlist))->assertForbidden();
});

test('users cannot delete their others’ wishlist', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs(User::factory()->create());
    $this->delete(route('wishlists.destroy', $wishlist))->assertForbidden();
});

test('users can delete their wishlist', function () {
    $wishlist = Wishlist::factory()->create();
    Wishlist::factory()->for($wishlist->user)->create();

    $this->actingAs($wishlist->user);
    $response = $this->delete(route('wishlists.destroy', $wishlist), [
        'original_name' => $wishlist->name,
        'wishlist_name' => $wishlist->name,
    ]);

    $response->assertRedirectToRoute('app');
    $this->assertSoftDeleted($wishlist);
});

test('users cannot delete their wishlist when enter wrong name', function () {
    $wishlist = Wishlist::factory()->create();
    Wishlist::factory()->for($wishlist->user)->create();

    $this->actingAs($wishlist->user);
    $response = $this->delete(route('wishlists.destroy', $wishlist), [
        'original_name' => $wishlist->name,
        'wishlist_name' => 'Incorrect name',
    ]);

    $response->assertSessionHasErrorsIn('wishlistDeletion', 'wishlist_name');
    $this->assertNotNull($wishlist->fresh());
});