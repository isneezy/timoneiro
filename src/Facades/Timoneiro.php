<?php
namespace Isneezy\Timoneiro\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed routes()
 */
class Timoneiro extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'timoneiro';
    }
}
