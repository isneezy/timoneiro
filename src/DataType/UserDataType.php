<?php

namespace Isneezy\Timoneiro\DataType;

use Illuminate\Support\Facades\Config;
use Isneezy\Timoneiro\Http\UserCreateAddRequest;
use Isneezy\Timoneiro\Policies\UserPolicy;

class UserDataType extends AbstractDataType
{
    public $policy_name = UserPolicy::class;
    public $icon_class = 'mdi mdi-account-multiple';
    public $rules = UserCreateAddRequest::class;
    public $service = UserService::class;

    public function __construct(array $options = [])
    {
        $this->model_name = Config::get('auth.providers.users.model');
        $this->field_set = [
            'role_id'               => ['display_name' => 'Role'],
            'password'              => ['type' => 'password', 'name' => 'password', 'class' => 'w-1/2', 'order' => 390],
            'password_confirmation' => ['type' => 'password', 'name' => 'password_confirmation', 'class' => 'w-1/2', 'order' => 391, 'display_name' => 'Confirm password', 'persist' => false],
        ];

        parent::__construct($options);
    }
}
