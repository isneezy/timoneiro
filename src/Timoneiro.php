<?php

namespace Isneezy\Timoneiro;

use Arrilot\Widgets\Facade as Widget;
use isneezy\timoneiro\Widgets\BaseDimmer;

class Timoneiro
{
    protected static $dataTypes = [];

    public static function dataTypes() {
        if (empty(self::$dataTypes)) {
            foreach (config('timoneiro.models') as $key => $model) {
                $dataType = DataType::make($key, $model);
                self::$dataTypes[$dataType->slug()] = $dataType;
            }
        }
        return self::$dataTypes;
    }

    /**
     * @param $slug
     * @return DataType
     */
    public static function dataType($slug) {
        return self::$dataTypes[$slug];
    }

    public static function routes() {
        require __DIR__.'/../routes/routes.php';
    }

    public static function view($name, array $params = [])
    {
        return view($name, $params);
    }

    public static function dimmers() {
        $widgetClasses = config('timoneiro.dashboard.widgets');
        $dimmers = Widget::group('timoneiro::dimmers');

        foreach ($widgetClasses as $widgetClass) {
            /** @var BaseDimmer $widget */
            $widget = app($widgetClass);
            if ($widget->shouldDisplay()) {
                $dimmers->addWidget($widgetClass);
            }
        }

        return $dimmers;
    }
}
