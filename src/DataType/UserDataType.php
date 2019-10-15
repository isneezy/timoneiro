<?php

namespace Isneezy\Timoneiro\DataType;


use Illuminate\Support\Facades\Config;
use Isneezy\Timoneiro\Policies\UserPolicy;

class UserDataType extends AbstractDataType
{
    public $policy_name = UserPolicy::class;
    public $icon_class = 'mdi mdi-account-multiple';
    public $rules = [
        'role_id' => 'required|exists:roles,id',
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'verified_at' => 'sometimes|datetime'
    ];

    public function __construct(array $options = [])
    {
        $this->model_name = Config::get('auth.providers.users.model');
        $this->field_set = ['role_id' => ['display_name' => 'Role']];

        parent::__construct($options);
    }
}