<?php

namespace Isneezy\Timoneiro\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Model of the user_group_permissions table
 * @package Isneezy\Timoneiro
 */
class RolePermission extends Model
{
    protected $fillable = ['group_id', 'permission'];
}
