<?php

test('guest see the default wishlist', function() {
    $response = $this->get(route('guests.wishlists.show'));

    $response->assertOk();

    $this->assertGuest();
    $response->assertSessionHas('wishlist', function(array $wishlist) {
        return $wishlist === DEFAULT_WISHLIST;
    });
});
