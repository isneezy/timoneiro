<?php

namespace Isneezy\Timoneiro\Widgets;

class WelcomeDimmer extends BaseDimmer
{
    public function run()
    {
        $title = 'Wecome ';
        $icon = 'mdi mdi-bullhorn';
        $variant = 'warning';
        $description = auth()->user()->name;

        return view('timoneiro::dimmer', compact('title', 'icon', 'description', 'variant'));
    }

    public function shouldDisplay()
    {
        return auth()->check();
    }
}
