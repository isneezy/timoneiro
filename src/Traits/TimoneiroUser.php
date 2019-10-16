<?php

namespace Isneezy\Timoneiro\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\UnauthorizedException;
use Isneezy\Timoneiro\Facades\Timoneiro;
use Isneezy\Timoneiro\Models\Role;

/**
 * @property Role $role
 */
trait TimoneiroUser
{
    /**
     * @return BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Timoneiro::dataType('roles')->model_name);
    }

    public function hasRole($name)
    {
        if ($role = $this->role) {
            return $role->name === $name;
        }

        return false;
    }

    public function setRole($name)
    {
        $role = Timoneiro::dataType('roles')->model_name::where(['name' => $name])->fisrst();

        if ($role) {
            $this->role()->associate($role);
            $this->save();
        }

        return $this;
    }

    public function hasPermission($name)
    {
        $role = $this->role;
        if ($role) {
            return in_array($name, $role->permissions ?? []);
        }

        return false;
    }

    public function hasPermissionOrFail($name)
    {
        if (!$this->hasPermission($name)) {
            throw new UnauthorizedException(null);
        }

        return true;
    }

    public function hasPermissionOrAbort($name, $statusCode)
    {
        if (!$this->hasPermission($name)) {
            return abort($statusCode);
        }

        return true;
    }
}
