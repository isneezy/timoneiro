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
    ],
];
