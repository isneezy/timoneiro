<?php

namespace Isneezy\Timoneiro\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for user_groups table.
 */
class Role extends Model
{
    protected $table = 'user_groups';
    protected $fillable = ['name'];

    protected $hidden = ['id'];
}
