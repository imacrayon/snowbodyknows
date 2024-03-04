<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\GrantedWishController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SortWishlistController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\WishlistCommentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WishlistViewerController;
use App\Http\Controllers\Guest\GuestWishController;
use App\Http\Controllers\Guest\GuestWishlistController;
use App\Http\Controllers\Guest\GuestSortWishlistController;
use App\Http\Controllers\SettingsController;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('/affiliates', 'markdown', ['slot' => Str::markdown(file_get_contents(resource_path('markdown/affiliates.md')))]);

Route::get('/wishlists/{wishlist:invite_code}/join', [WishlistViewerController::class, 'create'])->name('wishlists.viewers.create');
Route::post('/wishlists/{wishlist:invite_code}/join', [WishlistViewerController::class, 'store'])->name('wishlists.viewers.store')->middleware('auth');
Route::get('/guest/wishlists/', [GuestWishlistController::class, 'show'])->name('guests.wishlists.show');
Route::get('/guest/wishlists/wish', [GuestWishController::class, 'create'])->name('guests.wishes.create');
Route::post('/guest/wishlists/wish', [GuestWishController::class, 'store'])->name('guests.wishes.store');
Route::get('/guest/wishlists/wishes/{wishId}/edit', [GuestWishController::class, 'edit'])->name('guests.wishes.edit');
Route::patch('/guest/wishlists/wishes/{wishId}', [GuestWishController::class, 'update'])->name('guests.wishes.update');
Route::delete('/guest/wishlists/wishes/{wishId}', [GuestWishController::class, 'destroy'])->name('guests.wishes.destroy');
Route::post('/guest/wishlists/sort', GuestSortWishlistController::class)->name('guests.wishlists.sort');

Route::middleware('auth')->prefix('/app')->group(function () {
    Route::get('/', AppController::class)->name('app');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlists.index');
    Route::get('/wishlists/create', [WishlistController::class, 'create'])->name('wishlists.create')->can('create', Wishlist::class);
    Route::post('/wishlists', [WishlistController::class, 'store'])->name('wishlists.store')->can('create', Wishlist::class);
    Route::get('/wishlists/{wishlist}', [WishlistController::class, 'show'])->name('wishlists.show')->can('view', 'wishlist');
    Route::get('/wishlists/{wishlist}/edit', [WishlistController::class, 'edit'])->name('wishlists.edit')->can('update', 'wishlist');
    Route::patch('/wishlists/{wishlist}', [WishlistController::class, 'update'])->name('wishlists.update')->can('update', 'wishlist');
    Route::delete('/wishlists/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlists.destroy')->can('delete', 'wishlist');

    Route::delete('/wishlists/{wishlist}/users/{user}', [WishlistViewerController::class, 'destroy'])->name('wishlists.viewers.destroy')->can('kick', ['wishlist', 'user']);

    Route::post('/wishlists/{wishlist}/sort', SortWishlistController::class)->name('wishlists.sort')->can('update', 'wishlist');

    // comments
    Route::get('/wishlists/{wishlist}/comments/{comment}', [WishlistCommentController::class, 'show'])->name('wishlists.comments.show');
    Route::get('/wishlists/{wishlist}/comments/{comment}/edit', [WishlistCommentController::class, 'edit'])->name('wishlists.comments.edit')->can('update', 'comment');
    Route::post('/wishlists/{wishlist}/comments', [WishlistCommentController::class, 'store'])->name('wishlists.comments.store')->can('view', 'wishlist');
    Route::patch('/wishlists/{wishlist}/comments/{comment}', [WishlistCommentController::class, 'update'])->name('wishlists.comments.update')->can('update', 'comment');
    Route::delete('/wishlists/{wishlist}/comments/{comment}', [WishlistCommentController::class, 'destroy'])->name('wishlists.comments.destroy')->can('delete', 'comment');
    // comments

    Route::get('/wishlists/{wishlist}/wish', [WishController::class, 'create'])->name('wishes.create')->can('update', 'wishlist');
    Route::post('/wishlists/{wishlist}/wish', [WishController::class, 'store'])->name('wishes.store')->can('update', 'wishlist');
    Route::get('/wishlists/{wishlist}/wishes/{wish}/edit', [WishController::class, 'edit'])->name('wishes.edit')->can('update', 'wish');
    Route::patch('/wishlists/{wishlist}/wishes/{wish}', [WishController::class, 'update'])->name('wishes.update')->can('update', 'wish');
    Route::delete('/wishlists/{wishlist}/wishes/{wish}', [WishController::class, 'destroy'])->name('wishes.destroy')->can('delete', 'wish');

    Route::post('/wishes/{wish}/grant', [GrantedWishController::class, 'store'])->name('wishes.grants.store')->can('grant', 'wish');
    Route::delete('/wishes/{wish}/grant', [GrantedWishController::class, 'destroy'])->name('wishes.grants.destroy')->can('ungrant', 'wish');
});

require __DIR__.'/auth.php';
