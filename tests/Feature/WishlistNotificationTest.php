<?php

use App\Jobs\NotifyViewersOfNewWishes;
use App\Models\Group;
use App\Models\User;
use App\Models\Wish;
use App\Models\Wishlist;
use App\Notifications\WishesCreatedNotification;
use Illuminate\Support\Facades\Notification;

test('members are notified when a wish is added to a wishlist', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    Group::factory()->withWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($wishlist->user);
    $this->post(route('wishes.create', $wishlist), [
        'name' => 'New Wish',
        'url' => 'https://imacrayon.com',
        'description' => 'Test description.',
    ]);

    Notification::assertSentTo(
        $viewer,
        function (WishesCreatedNotification $notification) {
            return $notification->wishes->modelKeys() === [Wish::first()->id];
        }
    );

    Notification::assertNotSentTo($wishlist->user, WishesCreatedNotification::class);
});

test('members in multiple groups are notified only once', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    Group::factory()->withWishlist($wishlist)->withUser($viewer)->create();
    Group::factory()->withWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($wishlist->user);
    $this->post(route('wishes.create', $wishlist), [
        'name' => 'New Wish',
        'url' => 'https://imacrayon.com',
        'description' => 'Test description.',
    ]);

    Notification::assertSentTimes(WishesCreatedNotification::class, 1);
});

test('members who turned off wish emails are not notified', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create(['receives_wish_emails' => false]);
    Group::factory()->withWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($wishlist->user);
    $this->post(route('wishes.store', $wishlist), [
        'name' => 'New Wish',
    ]);

    Notification::assertNotSentTo($viewer, WishesCreatedNotification::class);
});

test('new wishes are announced together in one notification', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    Group::factory()->withWishlist($wishlist)->withUser($viewer)->create();
    [$secondWish, $firstWish] = Wish::factory()->for($wishlist)->notifyViewers()->count(2)->sequence(
        ['order' => 2],
        ['order' => 1],
    )->create();
    Wish::factory()->for($wishlist)->create();

    NotifyViewersOfNewWishes::dispatchSync($wishlist);

    Notification::assertSentTimes(WishesCreatedNotification::class, 1);
    Notification::assertSentTo(
        $viewer,
        fn (WishesCreatedNotification $notification) => $notification->wishes->modelKeys() === [$firstWish->id, $secondWish->id]
    );
    expect($firstWish->refresh()->notify_viewers)->toBeFalse()
        ->and($secondWish->refresh()->notify_viewers)->toBeFalse();
});

test('viewers are not notified about wishes on a deleted wishlist', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    Group::factory()->withWishlist($wishlist)->withUser($viewer)->create();
    Wish::factory()->for($wishlist)->notifyViewers()->create();
    $wishlist->delete();

    NotifyViewersOfNewWishes::dispatchSync($wishlist);

    Notification::assertNothingSent();
});

test('wish notification emails link to unsubscribe', function () {
    $wishlist = Wishlist::factory()->create(['name' => 'Birthday']);
    $viewer = User::factory()->create();
    $wishes = Wish::factory()->for($wishlist)->count(2)->sequence(
        ['name' => 'Telescope'],
        ['name' => 'Rain boots'],
    )->create();

    Notification::sendNow($viewer, new WishesCreatedNotification($wishlist, $wishes));

    $email = app('mailer')->getSymfonyTransport()->messages()->sole()->getOriginalMessage();
    $unsubscribeUrl = url("/users/{$viewer->id}/unsubscribe/wishes?signature=");
    expect($email->getSubject())->toBe('2 wishes added to Birthday')
        ->and($email->getHtmlBody())->toContain('Telescope', 'Rain boots', $unsubscribeUrl)
        ->and($email->getHeaders()->get('List-Unsubscribe')->getBodyAsString())->toStartWith("<{$unsubscribeUrl}")
        ->and($email->getHeaders()->get('List-Unsubscribe-Post')->getBodyAsString())->toBe('List-Unsubscribe=One-Click');
});
