<?php

return [
    'controllers' => [
        'namespace' => 'Isneezy\\Timoneiro\\Http\\Controllers',
    ],
    'models' => [
        'Users' => [
            'model_name' => \App\User::class,
            // 'list_display' => ['name', 'email', 'verified'],
            'icon_class' => 'mdi mdi-account-multiple',
        ],
        'Roles' => [
            'model_name' => \Isneezy\Timoneiro\Models\Role::class,
            'icon_class' => 'mdi mdi-lock',
        ],
    ],
    'dashboard' => [
        'widgets' => [
            \isneezy\timoneiro\Widgets\WelcomeDimmer::class,
            \isneezy\timoneiro\Widgets\UserDimmer::class,
            \isneezy\timoneiro\Widgets\UserDimmer::class,
        ],
    ],
    'settings' => [
    ],
];
