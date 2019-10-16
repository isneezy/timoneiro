<?php

namespace Isneezy\Timoneiro\Http\Controllers\ContentTypes;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class Password extends BaseType
{
    public function handle()
    {
        $password = Arr::get($this->data, $this->field->name);
        if ($password) {
            return Hash::make($password);
        }

        return $this->model->password;
    }
}
