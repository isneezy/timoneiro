<?php

return [
    'controllers' => [
        'namespace' => 'Isneezy\\Timoneiro\\Http\\Controllers',
    ],
    'models' => [
        //        'Users' => [
        //            'model_name' => \App\User::class,
        //            // 'list_display' => ['name', 'email', 'verified'],
        //            'icon_class' => 'mdi mdi-account-multiple',
        //        ]
    ],
    'dashboard' => [
        'widgets' => [
            \Isneezy\Timoneiro\Widgets\WelcomeDimmer::class,
            \Isneezy\Timoneiro\Widgets\UserDimmer::class,
            \Isneezy\Timoneiro\Widgets\UserDimmer::class,
        ],
    ],
    'settings' => [
    ],
];
