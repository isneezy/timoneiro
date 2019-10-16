<?php

namespace Isneezy\Timoneiro;

use Arrilot\Widgets\Facade as Widget;
use ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Isneezy\Timoneiro\Actions\DeleteAction;
use Isneezy\Timoneiro\Actions\EditAction;
use Isneezy\Timoneiro\Actions\RestoreAction;
use Isneezy\Timoneiro\Actions\ViewAction;
use Isneezy\Timoneiro\DataType\AbstractDataType;
use Isneezy\Timoneiro\DataType\DataType;
use Isneezy\Timoneiro\DataType\DataTypeField;
use Isneezy\Timoneiro\DataType\RoleDataType;
use Isneezy\Timoneiro\DataType\UserDataType;
use Isneezy\Timoneiro\FormFields\HandlerInterface;
use Isneezy\Timoneiro\Models\Setting;
use Isneezy\Timoneiro\Widgets\BaseDimmer;

class Timoneiro
{
    protected $settings = [];
    protected $isDataTypesLoaded = false;
    protected $dataTypes = [];
    protected $formFields = [];
    protected $actions = [
        ViewAction::class,
        EditAction::class,
        DeleteAction::class,
        RestoreAction::class,
    ];

    protected $permissions = [
        'System' => [
            'browse_admin',
            'browse_media',
            'browse_settings'
        ]
    ];

    public function loadDataTypes()
    {
        if (!$this->isDataTypesLoaded) {
            foreach (config('timoneiro.models') as $model) {
                $dataType = DataType::make($model);
                $this->useDataType($dataType);
            }
            $this->useDataType(new UserDataType());
            $this->useDataType(new RoleDataType());
        }
    }

    public function dataTypes()
    {
        $this->loadDataTypes();

        return $this->dataTypes;
    }

    /**
     * @param $slug
     *
     * @return DataType
     */
    public function dataType($slug)
    {
        $this->loadDataTypes();

        return $this->dataTypes[$slug];
    }

    /**
     * @param string | AbstractDataType $dataType
     */
    public function useDataType($dataType)
    {
        if (is_string($dataType)) {
            $dataType = app($dataType);
        }
        $this->dataTypes[$dataType->slug] = $dataType;
    }

    public function routes()
    {
        require __DIR__.'/../routes/routes.php';
    }

    /**
     * @param string $group
     * @param array $permissions
     */
    public function mergePermissions($group, array $permissions) {
        $_permissions = Arr::get($this->permissions, $group, []);
        $permissions = collect(array_merge($_permissions, $permissions))->flatten()->all();
        $this->permissions[$group] = $permissions;
    }

    public function permissions($grouped = false) {
        $permissions = collect($this->permissions);
        if (!$grouped) {
            return collect($this->permissions)->flatten();
        }
        return $permissions;
    }

    public function view($name, array $params = [])
    {
        return view($name, $params);
    }

    public function actions()
    {
        return $this->actions;
    }

    public function addAction($action)
    {
        array_push($this->actions, $action);
    }

    public function replaceAction($actionToReplace, $action)
    {
        $key = array_search($actionToReplace, $this->actions);
        $this->actions[$key] = $action;
    }

    /**
     * @param DataTypeField $field
     * @param DataType      $dataType
     * @param Model         $data
     *
     * @throws ErrorException
     *
     * @return string
     */
    public function formField($field, $dataType, $data)
    {
        $formField = Arr::get($this->formFields, $field->type);
        if (!$formField) {
            Log::warning(
                "No Handler for `$field->type` found. Falling back to `text`",
                compact('field', 'dataType', 'data')
            );
            $formField = $this->formFields['text'];
        }

        return $formField->handle($field, $dataType, $data);
    }

    public function addFormField($handler)
    {
        if (!$handler instanceof HandlerInterface) {
            $handler = app($handler);
        }
        $this->formFields[$handler->getCodename()] = $handler;
    }

    public function setting($key, $default = null)
    {
        if (empty($this->settings)) {
            foreach (Setting::all() as $setting) {
                $this->settings[$setting->key] = $setting->value;
            }
        }

        return Arr::get($this->settings, $key, $default);
    }

    public function dimmers()
    {
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
