<?php

namespace Isneezy\Timoneiro\Widgets;

class UserDimmer extends BaseDimmer
{
    public function run()
    {
        $model = config('auth.providers.users.model');
        $title = $model::count();
        $icon = 'mdi mdi-account';
        $variant = 'primary';
        $description = 'Total Users';

        return view('timoneiro::dimmer', compact('title', 'icon', 'description', 'variant'));
    }
}
