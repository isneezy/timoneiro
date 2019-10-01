<?php

namespace isneezy\timoneiro\Http\Controllers\ContentTypes;


class Text extends BaseType
{

    public function handle()
    {
        return $this->request->input($this->field->name);
    }
}
