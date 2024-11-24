<?php

use App\Models\Group;
use App\Models\User;
use App\Models\Wish;
use App\Models\Wishlist;
use App\Notifications\WishCreatedNotification;
use Illuminate\Support\Facades\Notification;

test('members are notified when a wish is added to a wishlist', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    Group::factory()->forWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($wishlist->user);
    $this->post(route('wishes.create', $wishlist), [
        'name' => 'New Wish',
        'url' => 'https://imacrayon.com',
        'description' => 'Test description.',
    ]);

    Notification::assertSentTo(
        $viewer,
        function (WishCreatedNotification $notification) {
            return $notification->wish->id === Wish::first()->id;
        }
    );

    Notification::assertNotSentTo($wishlist->user, WishCreatedNotification::class);
});

test('members in multiple groups are notified only once', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    Group::factory()->forWishlist($wishlist)->withUser($viewer)->create();
    Group::factory()->forWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($wishlist->user);
    $this->post(route('wishes.create', $wishlist), [
        'name' => 'New Wish',
        'url' => 'https://imacrayon.com',
        'description' => 'Test description.',
    ]);

    Notification::assertSentTimes(WishCreatedNotification::class, 1);
});
