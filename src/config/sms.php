<?php

return [
    'default' => env('SMS_PROVIDER', 'log'),

    'smsmisr' => [
        'username' => env('SMSMISR_USERNAME'),
        'passowrd' => env('SMSMISR_PASSWORD'),
        'sender'   => env('SMSMISR_SENDER'),
    ],

    'log'     => [
        'channel' => '',
    ],
];
