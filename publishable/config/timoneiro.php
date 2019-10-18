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
            'title' => ['type' => 'text'],
            'logo'  => ['type' => 'file', 'mime_types' => ['image/jpeg', 'image/svg+xml', 'image/png', 'image/gif']],
        ],
    ],
    'media' => [
        'show_hidden_files' => false,
        'mime_types'        => ['*'],
    ],
];
