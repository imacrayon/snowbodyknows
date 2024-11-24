<?php

use App\Models\Comment;
use App\Models\Group;
use App\Models\User;
use App\Models\Wishlist;
use App\Notifications\WishlistCommentCreatedNotification;
use Illuminate\Support\Facades\Notification;

test('wishlist owner can create comments', function () {
    $wishlist = Wishlist::factory()->create();

    $this->actingAs($wishlist->user);
    $response = $this->post(route('wishlists.comments.store', $wishlist), [
        'comment' => 'Test comment.',
    ]);

    $response->assertRedirectToRoute('wishlists.show', $wishlist);
    expect($wishlist->comments()->first())->content->toBe('Test comment.');
});

test('viewer can create comments', function () {
    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    Group::factory()->forWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($viewer);
    $response = $this->post(route('wishlists.comments.store', $wishlist), [
        'comment' => 'Test comment.',
    ]);

    $response->assertRedirectToRoute('wishlists.show', $wishlist);
    expect($wishlist->comments()->first())->content->toBe('Test comment.');
});

test('wishlist viewer comments are anonymous', function () {
    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    Group::factory()->forWishlist($wishlist)->withUser($viewer)->create();
    $wishlist->addComment('Test', $viewer);

    $this->actingAs($wishlist->user)
        ->get(route('wishlists.show', $wishlist))
        ->assertSeeText('A viewer commented')
        ->assertSee('face.svg')
        ->assertDontSeeText("{$viewer->name} commented");

    $this->actingAs($viewer)
        ->get(route('wishlists.show', $wishlist))
        ->assertSeeText('A viewer commented')
        ->assertSee('face.svg')
        ->assertDontSeeText("{$viewer->name} commented");
});

test('wishlist owner comments are not anonymous', function () {
    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    Group::factory()->forWishlist($wishlist)->withUser($viewer)->create();
    $wishlist->addComment('Test', $wishlist->user);

    $this->actingAs($wishlist->user)
        ->get(route('wishlists.show', $wishlist))
        ->assertSeeText("{$wishlist->user->name} commented")
        ->assertDontSeeText('A viewer commented')
        ->assertDontSee('face.svg');

    $this->actingAs($viewer)
        ->get(route('wishlists.show', $wishlist))
        ->assertSeeText("{$wishlist->user->name} commented")
        ->assertDontSeeText('A viewer commented');
});

test('wishlist owners can delete any comment', function () {
    $wishlist = Wishlist::factory()->create();
    $viewerA = User::factory()->create();
    $viewerB = User::factory()->create();
    Group::factory()->forWishlist($wishlist)
        ->withUser($viewerA)
        ->withUser($viewerB)
        ->create();
    $ownerComment = $wishlist->addComment('Test', $wishlist->user);
    $commentA = $wishlist->addComment('Test', $viewerA);
    $commentB = $wishlist->addComment('Test', $viewerB);

    $this->actingAs($wishlist->user);

    $this->delete(route('wishlists.comments.destroy', [$wishlist, $ownerComment]))
        ->assertRedirect(route('wishlists.show', $wishlist));
    $this->delete(route('wishlists.comments.destroy', [$wishlist, $commentB]))
        ->assertRedirect(route('wishlists.show', $wishlist));
    $this->delete(route('wishlists.comments.destroy', [$wishlist, $commentA]))
        ->assertRedirect(route('wishlists.show', $wishlist));

    $this->assertDatabaseCount('comments', 0);
});

test('wishlist members can only delete their own comments', function () {
    $wishlist = Wishlist::factory()->create();
    $viewerA = User::factory()->create();
    $viewerB = User::factory()->create();
    Group::factory()->forWishlist($wishlist)
        ->withUser($viewerA)
        ->withUser($viewerB)
        ->create();
    $ownerComment = $wishlist->addComment('Test', $wishlist->user);
    $commentA = $wishlist->addComment('Test', $viewerA);
    $commentB = $wishlist->addComment('Test', $viewerB);

    $this->actingAs($viewerA);

    $this->delete(route('wishlists.comments.destroy', [$wishlist, $ownerComment]))->assertForbidden();
    $this->delete(route('wishlists.comments.destroy', [$wishlist, $commentB]))->assertForbidden();
    $this->delete(route('wishlists.comments.destroy', [$wishlist, $commentA]))
        ->assertRedirect(route('wishlists.show', $wishlist));

    $this->assertModelMissing($commentA);
    expect(Comment::count())->toBe(2);
});

test('wishlist owner comments notify only members', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewerA = User::factory()->create();
    $viewerB = User::factory()->create();
    Group::factory()->forWishlist($wishlist)
        ->withUser($viewerA)
        ->withUser($viewerB)
        ->create();

    $this->actingAs($wishlist->user)->post(route('wishlists.comments.store', $wishlist), [
        'comment' => 'Test comment.',
    ]);

    Notification::assertSentTo(
        [$viewerA, $viewerB],
        function (WishlistCommentCreatedNotification $notification) {
            return $notification->comment->id === Comment::first()->id;
        }
    );

    Notification::assertNotSentTo(
        [$wishlist->user],
        WishlistCommentCreatedNotification::class
    );
});

test('wishlist members comments notify owner and other members', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewerA = User::factory()->create();
    $viewerB = User::factory()->create();
    Group::factory()->forWishlist($wishlist)
        ->withUser($viewerA)
        ->withUser($viewerB)
        ->create();

    $this->actingAs($viewerA)->post(route('wishlists.comments.store', $wishlist), [
        'comment' => 'Test comment.',
    ]);

    Notification::assertSentTo(
        [$wishlist->user, $viewerB],
        function (WishlistCommentCreatedNotification $notification) {
            return $notification->comment->id === Comment::first()->id;
        }
    );

    Notification::assertNotSentTo(
        [$viewerA],
        WishlistCommentCreatedNotification::class
    );
});

test('wishlist comments notify members in multiple groups only once', function () {
    Notification::fake();

    $wishlist = Wishlist::factory()->create();
    $viewer = User::factory()->create();
    Group::factory()->forWishlist($wishlist)->withUser($viewer)->create();
    Group::factory()->forWishlist($wishlist)->withUser($viewer)->create();

    $this->actingAs($wishlist->user)->post(route('wishlists.comments.store', $wishlist), [
        'comment' => 'Test comment.',
    ]);

    Notification::assertSentTimes(WishlistCommentCreatedNotification::class, 1);
});
