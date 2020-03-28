<?php

namespace Isneezy\Timoneiro\Policies;

use Isneezy\Timoneiro\Models\User;

class UserPolicy extends BasePolicy
{
    /**
     * @param User $user
     * @param $model
     *
     * @return bool
     */
    public function read(User $user, $model)
    {
        $current = $user->id === $model->id;

        return $current || $this->checkPermission($user, $model, 'read');
    }

    public function edit(User $user, $model)
    {
        $current = $user->id === $model->id;

        return $current || $this->checkPermission($user, $model, 'edit');
    }

    public function editRoles(User $user, $model)
    {
        $another = $user->id != $model->id;

        return $another && $user->hasPermission('edit_users');
    }
}
