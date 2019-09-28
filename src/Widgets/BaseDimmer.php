<?php

namespace Isneezy\Timoneiro\Widgets;


use Arrilot\Widgets\AbstractWidget;

abstract class BaseDimmer extends AbstractWidget
{
    public function shouldDisplay() {
        return true;
    }
}
