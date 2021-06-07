<?php

return [

    'url' => env('TEGETA_RESERVATION_URL', 'http://10.11.11.42'),

    'code' => env('TEGETA_RESERVATION_CODE', '001'),

    'environments' => [
        'testing' => [
            'url' => 'http://10.11.11.42',
        ],
        'production' => [
            'url' => '',
        ],
    ],
];
