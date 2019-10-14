<?php

namespace Isneezy\Timoneiro\Http\Controllers\ContentTypes;

use Illuminate\Support\Arr;

class Text extends BaseType
{
    public function handle()
    {
        return Arr::get($this->data, $this->field->name);
    }
}
