<?php

use App\Models\User;
use App\Models\Wish;
use App\Models\Wishlist;

test('users can add to their wishlists', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('wishes.create', $wishlist), [
        'name' => 'New Wish',
        'url' => 'https://imacrayon.com',
        'description' => 'Test description.',
    ]);

    $response->assertRedirectToRoute('wishlists.show', $wishlist);
    expect(Wish::first())
        ->name->toBe('New Wish')
        ->url->toBe('https://imacrayon.com')
        ->description->toBe('Test description.');
});

test('users cannot add to others’ wishlists', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs(User::factory()->create());
    $this->post(route('wishes.create', $wishlist))->assertForbidden();
});

test('users can update their wishes', function () {
    $wish = Wish::factory()->create([
        'name' => 'Old Wish',
        'url' => 'https://example.com',
        'description' => 'Old description.',
    ]);

    $this->actingAs($wish->wishlist->user);
    $response = $this->patch(route('wishes.update', [$wish->wishlist, $wish]), [
        'name' => 'New Wish',
        'url' => 'https://imacrayon.com',
        'description' => 'New description.',
    ]);

    $response->assertRedirectToRoute('wishlists.show', $wish->wishlist);
    expect($wish->fresh())
        ->name->toBe('New Wish')
        ->url->toBe('https://imacrayon.com')
        ->description->toBe('New description.');
});

test('users cannot update others’ wishes', function () {
    $wish = Wish::factory()->create();

    $this->actingAs(User::factory()->create());
    $this->patch(route('wishes.update', [$wish->wishlist, $wish]))->assertForbidden();
});

test('users can delete their wishes', function () {
    $wish = Wish::factory()->create();

    $this->actingAs($wish->wishlist->user);
    $response = $this->delete(route('wishes.destroy', [$wish->wishlist, $wish]));

    $response->assertRedirectToRoute('wishlists.show', $wish->wishlist);
    $this->assertSoftDeleted($wish);
});

test('users cannot delete others’ wishes', function () {
    $wish = Wish::factory()->create();

    $this->actingAs(User::factory()->create());
    $this->delete(route('wishes.destroy', [$wish->wishlist, $wish]))->assertForbidden();
});
