<?php

namespace Isneezy\Timoneiro\DataType;


use Isneezy\Timoneiro\Models\Role;

class RoleDataType extends AbstractDataType
{
    public $model_name = Role::class;
    public $icon_class = 'mdi mdi-lock';
}