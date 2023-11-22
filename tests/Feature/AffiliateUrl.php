<?php

use App\Models\Wish;

beforeEach(function () {
    config(['affiliates' => ['example.com' => ['code' => 'TEST', 'remove' => null]]]);
});

test('only manipulates configured domains', function () {
    $wish = Wish::factory()->create(['url' => 'https://snowbodyknows.com']);

    expect($wish->url)->toBe('https://snowbodyknows.com');
});

test('adds affiliate codes to a URL', function () {
    $wish = Wish::factory()->create(['url' => 'https://example.com']);

    expect($wish->url)->toBe('https://example.com?code=TEST');
});

test('preserves paths when changing a URL', function () {
    $wish = Wish::factory()->create(['url' => 'https://example.com/a/url/path']);

    expect($wish->url)->toBe('https://example.com/a/url/path?code=TEST');
});

test('preserves other parameters when changing a URL', function () {
    $wish = Wish::factory()->create(['url' => 'https://example.com?default=KEEP_ME']);

    expect($wish->url)->toBe('https://example.com?default=KEEP_ME&code=TEST');
});

test('overwrites affiliate codes in a URL', function () {
    $wish = Wish::factory()->create(['url' => 'https://example.com?code=CHANGE_ME']);

    expect($wish->url)->toBe('https://example.com?code=TEST');
});

test('removes parameters from a URL', function () {
    $wish = Wish::factory()->create(['url' => 'https://example.com?default=KEEP_ME&remove=REMOVE_ME']);

    expect($wish->url)->toBe('https://example.com?default=KEEP_ME&code=TEST');
});
