<?php

namespace Isneezy\Timoneiro;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Isneezy\Timoneiro\Database\DatabaseSchemaManager;
use Isneezy\Timoneiro\Http\Controllers\TimoneiroBaseController;

/**
 * Class AbstractDataType
 * @package Isneezy\Timoneiro
 * @property string slug
 * @property string controller
 * @property string model_name
 * @property string display_name_singular
 * @property string $display_name_plural
 * @property string icon_class
 * @property array list_display
 * @property array scopes
 */
class AbstractDataType
{
    protected $options = [];

    public function __construct(array $options = [])
    {
        $this->options = array_merge_recursive($options, $this->options);
    }

    public function getControllerOption($value)
    {
        $controller = value_fallback($value, TimoneiroBaseController::class);
        return Str::start($controller, '\\');
    }

    public function getDisplayNameSingularOption($value) {
        return value_fallback($value, function () {
            return Str::title(Str::singular(str_replace('_', ' ', $this->slug)));
        });
    }

    public function getDisplayNamePluralOption($value) {
        return value_fallback($value, function () {
            return Str::plural($this->display_name_singular);
        });
    }

    public function getListDisplayOption($value)
    {
        return value_fallback($value, function () {
            /** @var Model $model */
            $model = app($this->model_name);
            return $this->options['list_display'] = DatabaseSchemaManager::describeTable($model->getTable())
                ->except($model->getHidden())
                ->keys()
                ->all();
        });
    }

    public function getScopesOption($value) {
        if (is_string($value)) $value = explode(',', $value);
        return $value ?? [];
    }

    public function getIconClassOption($value) {
        return value_fallback($value, 'mdi mdi-link');
    }

    public function getColumnLabel($column) {
        return Str::ucfirst(str_replace('_', ' ', $column));
    }

    public function setOptions(array $options) {
        $this->options = $options;
        return $this;
    }

    public function getOption($name)
    {
        $value = Arr::get($this->options, $name);
        $getter = Str::camel("get_$name".'_option');
        if (method_exists($this, $getter)) {
            $value = $this->{$getter}($value);
        }
        return $value;
    }

    public function setOption($name, $value)
    {
        $setter = Str::camel("set_$name".'_option');
        if (method_exists($this, $setter)) {
            $this->{$setter}($value);
        } else {
            $this->options[$name] = $value;
        }
    }

    public function __get($name)
    {
        return $this->getOption($name);
    }

    public function __set($name, $value)
    {
        $this->setOption($name, $value);
    }
}
