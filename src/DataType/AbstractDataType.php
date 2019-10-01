<?php

namespace Isneezy\Timoneiro\DataType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Isneezy\Timoneiro\Database\DatabaseSchemaManager;
use Isneezy\Timoneiro\DataType\Traits\HasOptions;
use Isneezy\Timoneiro\Http\Controllers\TimoneiroBaseController;
use Isneezy\Timoneiro\DataType\DataTypeField;

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
 * @property array field_set
 */
class AbstractDataType
{
    use HasOptions;

    public function __construct(array $options = [])
    {
        $this->options = array_merge_recursive($options, $this->options);
    }

    public function getControllerOption($value)
    {
        $controller = value_fallback($value, TimoneiroBaseController::class);
        return Str::start($controller, '\\');
    }

    public function getDisplayNameSingularOption($value)
    {
        return value_fallback($value, function () {
            return Str::title(Str::singular(str_replace('_', ' ', $this->slug)));
        });
    }

    public function getDisplayNamePluralOption($value)
    {
        return value_fallback($value, function () {
            return Str::plural($this->display_name_singular);
        });
    }

    public function getListDisplayOption($value)
    {
        return value_fallback($value, function () {
            return $this->options['list_display'] = $this->describeTable()
                ->keys()
                ->all();
        });
    }

    public function getFieldSetOption($value)
    {
        return $this->describeTable()->map(function ($def) {
            return new DataTypeField($def);
        })->values()->all();
    }

    public function getScopesOption($value)
    {
        if (is_string($value)) $value = explode(',', $value);
        return $value ?? [];
    }

    public function getIconClassOption($value)
    {
        return value_fallback($value, 'mdi mdi-link');
    }

    public function getColumnLabel($column)
    {
        return Str::ucfirst(str_replace('_', ' ', $column));
    }

    protected function describeTable($hidden = false)
    {
        $model = app($this->model_name);
        $table = DatabaseSchemaManager::describeTable($model->getTable());
        if (!$hidden) {
            return $table->except($model->getHidden())->except($model->getKeyName());
        }
        return $table;
    }
}
