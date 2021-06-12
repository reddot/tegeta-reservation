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

    'vehicle_types' => [
        ['input_name' => 'light', 'view_name' => 'მსუბუქი'],
        ['input_name' => 'truck', 'view_name' => 'სატვირთო'],
        ['input_name' => 'van', 'view_name' => 'მიკროავტობუსი'],
    ],

    'user_type' => [
        ['input_name' => 'person', 'view_name' => 'ფიზიკური პირი'],
        ['input_name' => 'company', 'view_name' => 'იურიდიული პირი'],
    ]
];
