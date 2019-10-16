<?php

namespace Isneezy\Timoneiro\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Isneezy\Timoneiro\Contracts\User;
use Isneezy\Timoneiro\DataType\AbstractDataType;
use Isneezy\Timoneiro\Facades\Timoneiro;

class BasePolicy
{
    use HandlesAuthorization;

    public function __call($name, $arguments)
    {
        if (count($arguments) < 2) {
            throw new \InvalidArgumentException('not enough arguments');
        }

        /** @var User $user */
        $user = $arguments[0];

        /** @var Model $model */
        $model = $arguments[1];

        return $this->checkPermission($user, $model, $name);
    }

    /**
     * Check if user has an associated permission.
     *
     * @param User   $user
     * @param Model  $model
     * @param string $action
     *
     * @return mixed
     */
    protected function checkPermission($user, $model, $action)
    {
        $dataType = collect(Timoneiro::dataTypes())->reduce(function ($value, AbstractDataType $dataType) use ($model) {
            if ($dataType->model_name === get_class($model)) {
                return $dataType;
            }

            return $value;
        });

        return $user->hasPermission("{$action}_{$dataType->slug}");
    }
}
