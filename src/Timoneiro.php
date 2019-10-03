<?php

namespace Isneezy\Timoneiro;

use Arrilot\Widgets\Facade as Widget;
use ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Isneezy\Timoneiro\Actions\DeleteAction;
use Isneezy\Timoneiro\Actions\EditAction;
use Isneezy\Timoneiro\Actions\RestoreAction;
use Isneezy\Timoneiro\Actions\ViewAction;
use Isneezy\Timoneiro\DataType\AbstractDataType;
use Isneezy\Timoneiro\DataType\DataType;
use Isneezy\Timoneiro\DataType\DataTypeField;
use Isneezy\Timoneiro\FormFields\HandlerInterface;
use Isneezy\Timoneiro\Models\Setting;
use isneezy\timoneiro\Widgets\BaseDimmer;

class Timoneiro
{
    protected static $settings = [];
    protected static $isDataTypesLoaded = false;
    protected static $dataTypes = [];
    protected static $formFields = [];
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

    /**
     * @param DataTypeField $field
     * @param DataType $dataType
     * @param Model $data
     * @return string
     * @throws ErrorException
     */
    public static function formField($field, $dataType, $data) {
        $formField = Arr::get(self::$formFields, $field->type);
        if ($formField) {
            return $formField->handle($field, $dataType, $data);
        }
        throw new ErrorException("No Handler for `$field->type` found.");
    }

    public static function addFormField($handler) {
        if (!$handler instanceof HandlerInterface) {
            $handler = app($handler);
        }
        self::$formFields[$handler->getCodename()] = $handler;
    }

    public static function setting($key, $default = null) {
        if (empty(self::$settings)) {
            foreach (Setting::all() as $setting) {
                self::$settings[$setting->key] = $setting->value;
            }
        }

        return Arr::get(self::$settings, $key, $default);
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
