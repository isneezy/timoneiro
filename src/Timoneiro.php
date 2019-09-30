<?php

namespace Isneezy\Timoneiro;

use Arrilot\Widgets\Facade as Widget;
use Isneezy\Timoneiro\Actions\DeleteAction;
use Isneezy\Timoneiro\Actions\EditAction;
use Isneezy\Timoneiro\Actions\RestoreAction;
use Isneezy\Timoneiro\Actions\ViewAction;
use isneezy\timoneiro\Widgets\BaseDimmer;

class Timoneiro
{
    protected static $isDataTypesLoaded = false;
    protected static $dataTypes = [];
    protected static $actions = [
        ViewAction::class,
        EditAction::class,
        DeleteAction::class,
        RestoreAction::class
    ];

    public static function loadDataTypes() {
        if (!self::$isDataTypesLoaded) {
            foreach (config('timoneiro.models') as $key => $model) {
                $dataType = DataType::make($key, $model);
                self::useDataType($dataType);
            }
        }
    }

    public static function dataTypes() {
        self::loadDataTypes();
        return self::$dataTypes;
    }

    /**
     * @param $slug
     * @return DataType
     */
    public static function dataType($slug) {
        self::loadDataTypes();
        return self::$dataTypes[$slug];
    }

    /**
     * @param string | AbstractDataType $dataType
     */
    public static function useDataType($dataType) {
        if (is_string($dataType)) {
            $dataType = app($dataType);
        }
        self::$dataTypes[$dataType->slug] = $dataType;
    }

    public static function routes() {
        require __DIR__.'/../routes/routes.php';
    }

    public static function view($name, array $params = [])
    {
        return view($name, $params);
    }

    public static function actions() {
        return self::$actions;
    }

    public static function addAction($action) {
        array_push(self::$actions, $action);
    }

    public static function replaceAction($actionToReplace, $action)
    {
        $key = array_search($actionToReplace, self::$actions);
        self::$actions[$key] = $action;
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
