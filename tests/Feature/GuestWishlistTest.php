<?php

const DEFAULT_WISHLIST = [
    'name' => 'My wishlist',
    'id' => 0,
    'wishes' => []
];

test('guest see the default wishlist', function() {
    $response = $this->get(route('guests.wishlists.show'));

    $response->assertOk();

    $this->assertGuest();
    $response->assertSessionHas('wishlist', function(array $wishlist) {
        return $wishlist === DEFAULT_WISHLIST;
    });
});
