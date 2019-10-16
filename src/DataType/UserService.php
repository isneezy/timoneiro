<?php

namespace Isneezy\Timoneiro\DataType;


use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    public function create(array $data)
    {
        unset($data['password_confirm']);
        return parent::create($data);
    }

    public function update($model, array $data)
    {
        unset($data['password_confirm']);
        return parent::update($model, $data);
    }
}