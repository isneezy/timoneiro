<?php

namespace Isneezy\Timoneiro\Traits;

use Illuminate\View\View;

trait Renderable
{
    /**
     * Get the evaluated contents of the object.
     *
     * @param $content
     *
     * @return string
     */
    public function render($content)
    {
        if ($content instanceof View) {
            return $content->render();
        }

        return $content;
    }
}
