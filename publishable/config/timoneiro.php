<?php
return [
    'controllers' => [
        'namespace' => 'Isneezy\\Timoneiro\\Http\\Controllers'
    ],
    'models' => [
        'Users' => [
            'model' => \App\User::class,
            // 'list_display' => ['name', 'email', 'verified'],
            'icon-class' => 'mdi mdi-account-multiple'
        ],
        'Roles' => [
            'model' => \Isneezy\Timoneiro\Models\Role::class,
            'icon-class' => 'mdi mdi-lock'
        ],
        'Settings' => [
            'model' => \Isneezy\Timoneiro\Models\Role::class,
            'icon-class' => 'mdi mdi-settings'
        ]
    ],
    'dashboard' => [
        'widgets' => [
            \isneezy\timoneiro\Widgets\WelcomeDimmer::class,
            \isneezy\timoneiro\Widgets\UserDimmer::class,
            \isneezy\timoneiro\Widgets\UserDimmer::class,
        ]
    ]
];
