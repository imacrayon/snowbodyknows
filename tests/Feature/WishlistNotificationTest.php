<?php

use App\Models\User;
use App\Models\Wish;
use App\Models\Wishlist;
use App\Notifications\WishCreatedNotification;
use Illuminate\Support\Facades\Notification;

test('viewers are notified when a wish is added to a wishlist', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    $wishlist->viewers()->attach($viewer);

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
});

test('viewers are not notified when a wish is added to a wishlist if settings is off', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    $settings = $viewer->settings;
    $settings['notification']['wish-created'] = false;
    $viewer->settings = $settings;
    $viewer->save();
    $wishlist->viewers()->attach($viewer);

    $this->actingAs($wishlist->user);
    $this->post(route('wishes.create', $wishlist), [
        'name' => 'New Wish',
        'url' => 'https://imacrayon.com',
        'description' => 'Test description.',
    ]);

    Notification::assertNotSentTo(
        $viewer,
        function (WishCreatedNotification $notification) {
            return $notification->wish->id === Wish::first()->id;
        }
    );
});