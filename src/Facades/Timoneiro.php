<?php

namespace Isneezy\Timoneiro\Facades;

use Arrilot\Widgets\WidgetGroup;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Illuminate\View\View;
use Isneezy\Timoneiro\DataType\DataType;

/**
 * @method static void loadDataTypes()
 * @method static array dataTypes()
 * @method static DataType dataType($slug)
 * @method static void useDataType(DataType $dataType)
 * @method static void routes()
 * @method static Collection permissions()
 * @method static View view($name, array $params = [])
 * @method static array actions()
 * @method static void addActions($action)
 * @method static void replaceAction($actionToReplace, $action)
 * @method static string formField($field, $dataType, $data)
 * @method static void addFormField($handler)
 * @method static mixed setting($key, $default)
 * @method static WidgetGroup dimmers()
 */
class Timoneiro extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'timoneiro';
    }
}
