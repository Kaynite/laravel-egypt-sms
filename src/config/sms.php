<?php

return [
    'default'  => env('SMS_PROVIDER', 'log'),

    'smsmisr'  => [
        'username' => env('SMSMISR_USERNAME'),
        'passowrd' => env('SMSMISR_PASSWORD'),
        'sender'   => env('SMSMISR_SENDER'),
    ],

    'smsegypt' => [
        'username'   => env('SMSEGYPT_USERNAME'),
        'passowrd'   => env('SMSEGYPT_PASSWORD'),
        'sendername' => env('SMSEGYPT_SENDER'),
    ],

    'log'      => [
        'channel' => '',
    ],
];
