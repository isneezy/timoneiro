<?php

return [
    'controllers' => [
        'namespace' => 'Isneezy\\Timoneiro\\Http\\Controllers',
    ],
    'models' => [
    ],
    'dashboard' => [
        'widgets' => [
            \Isneezy\Timoneiro\Widgets\WelcomeDimmer::class,
            \Isneezy\Timoneiro\Widgets\UserDimmer::class,
        ],
    ],
    'settings' => [
        'General' => [
            'logo' => ['type' => 'file', 'mime_types' => ['image/jpeg', 'image/svg+xml', 'image/png', 'image/gif']],
        ],
    ],
    'media' => [
        'mime_types' => ['*']
    ]
];
