<?php

namespace Isneezy\Timoneiro\Models;

use Illuminate\Database\Eloquent\Model;
use Isneezy\Timoneiro\Facades\Timoneiro;

/**
 * Model for user_groups table.
 */
class Role extends Model
{
    protected $guarded = [];
    protected $fillable = ['display_name'];
    protected $casts = ['permissions' => 'array'];

    protected $hidden = ['id'];

    public function users() {
        $class = Timoneiro::dataType('users')->model_name;
        return $this->hasMany($class);
    }

    public function __toString()
    {
        return $this->display_name;
    }
}
