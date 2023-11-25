<?php

const DEFAULT_WISHLIST = [
    'name' => 'My wishlist',
    'id' => 0,
    'wishes' => []
];

test('guest add a wish', function() {
    $response = $this->withSession(['wishlist' => DEFAULT_WISHLIST])
                        ->post(route('guests.wishes.create'), [
        'name' => 'New Wish',
        'url' => 'https://imacrayon.com',
        'description' => 'Test description.',
    ]);
     
    $response->assertRedirectToRoute('guests.wishlists.show');

    $response->assertSessionHas('wishlist', function(array $wishlist){
        return 
            $wishlist['wishes'][0]['name'] === 'New Wish' &&
            $wishlist['wishes'][0]['url'] === 'https://imacrayon.com' &&
            $wishlist['wishes'][0]['description'] === 'Test description.';
    }) ;
});

test('guest update a wish', function() {
    $defaultSession = array_merge(DEFAULT_WISHLIST, ['wishes' => [
       [
            'name' => 'New Wish',
            'url' => 'https://imacrayon.com',
            'description' => 'Test description.',
            'id' => 1
       ]
    ]]);
    $newValues = [
        'name' => 'New Wish updated',
        'url' => 'https://imacrayon.com/updated',
        'description' => 'Test description updated.',
    ];
    $response = $this->withSession(['wishlist' => $defaultSession])
                        ->patch(route('guests.wishes.update', 1), $newValues);

    $response->assertRedirectToRoute('guests.wishlists.show');

    $this->assertGuest();
    $newValues['id'] = 1;
    $response->assertSessionHas('wishlist', function(array $wishlist) use ($newValues): bool {
        return $wishlist['wishes'][0] === $newValues;
    });
});

test('guest delete a wish', function() {

    $defaultSession = array_merge(DEFAULT_WISHLIST, ['wishes' => [
       [
            'name' => 'New Wish',
            'url' => 'https://imacrayon.com',
            'description' => 'Test description.',
            'id' => 1
       ]
    ]]);
    $response = $this->withSession(['wishlist' => $defaultSession])
                        ->delete(route('guests.wishes.destroy', 1));

    $response->assertRedirectToRoute('guests.wishlists.show');

    $this->assertGuest();

    $response->assertSessionHas('wishlist', function(array $wishlist): bool {
        return $wishlist['wishes'] === [];
    });
});