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

test('users can add wishes with URLs containing symbols', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('wishes.create', $wishlist), [
        'name' => 'New Wish',
        'url' => 'https://www.amazon.com/Proofing-Box50-130°F-foldable/dp/B0FH16MBWT',
    ]);

    $response->assertRedirectToRoute('wishlists.show', $wishlist);
    expect(Wish::first())->url->toBe('https://www.amazon.com/Proofing-Box50-130°F-foldable/dp/B0FH16MBWT');
});

test('users cannot add wishes with non-web URLs', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('wishes.create', $wishlist), [
        'name' => 'New Wish',
        'url' => 'javascript:alert(1)',
    ]);

    $response->assertInvalid(['url' => 'The url field must start with one of the following: http://, https://.']);
    expect(Wish::count())->toBe(0);
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
