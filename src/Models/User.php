<?php

namespace Isneezy\Timoneiro\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Isneezy\Timoneiro\Contracts\User as UserContract;
use Isneezy\Timoneiro\Traits\TimoneiroUser;

class User extends Authenticatable implements UserContract
{
    use TimoneiroUser;

    protected $guarded = [];
}