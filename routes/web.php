<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlists.index');
    Route::get('/wishlists/create', [WishlistController::class, 'create'])->name('wishlists.create');
    Route::post('/wishlists', [WishlistController::class, 'store'])->name('wishlists.store');
    Route::get('/wishlists/{wishlist}', [WishlistController::class, 'show'])->name('wishlists.show');
    Route::get('/wishlists/{wishlist}/edit', [WishlistController::class, 'edit'])->name('wishlists.edit');
    Route::patch('/wishlists/{wishlist}', [WishlistController::class, 'update'])->name('wishlists.update');
    Route::delete('/wishlists/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlists.destroy');

    Route::get('/wishlists/{wishlist}/wish', [WishController::class, 'create'])->name('wishes.create');
    Route::post('/wishlists/{wishlist}/wish', [WishController::class, 'store'])->name('wishes.store');
    Route::get('/wishlists/{wishlist}/wishes/{wish}/edit', [WishController::class, 'edit'])->name('wishes.edit');
    Route::patch('/wishlists/{wishlist}/wishes/{wish}', [WishController::class, 'update'])->name('wishes.update');
});

require __DIR__.'/auth.php';
