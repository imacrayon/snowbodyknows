<?php

return [

    'mailers' => [
        'mailgun' => [
            'transport' => 'mailgun',
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],
    ],

    'reply_to' => [
        'address' => env('MAIL_REPLY_TO_ADDRESS'),
    ],

];
