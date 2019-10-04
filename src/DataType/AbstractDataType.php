<?php

namespace Isneezy\Timoneiro\DataType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Isneezy\Timoneiro\Database\DatabaseSchemaManager;
use Isneezy\Timoneiro\DataType\Traits\HasOptions;
use Isneezy\Timoneiro\Http\Controllers\TimoneiroBaseController;
use Isneezy\Timoneiro\Http\Controllers\Traits\RelationShipParser;

/**
 * Class AbstractDataType.
 *
 * @property string slug
 * @property string controller
 * @property string model_name
 * @property string display_name_singular
 * @property string $display_name_plural
 * @property string icon_class
 * @property array list_display
 * @property array scopes
 * @property array field_set
 * @property array relations
 */
class AbstractDataType
{
    use HasOptions, RelationShipParser;

    public function __construct(array $options = [])
    {
        $this->options = array_merge_recursive($options, $this->options);
    }

    public function getControllerOption($value)
    {
        $this->controller = value_fallback($value, TimoneiroBaseController::class);

        return Str::start($this->options['controller'], '\\');
    }

    public function getSlugOption($value) {
        return value_fallback($value, function () {
            return $this->options['slug'] = Str::kebab(Str::plural(class_basename($this->model_name)));
        });
    }

    public function getDisplayNameSingularOption($value)
    {
        return value_fallback($value, function () {
            return $this->options['display_name_singular'] = Str::title(
                Str::singular(str_replace(['_','-'], ' ', $this->slug))
            );
        });
    }

    public function getDisplayNamePluralOption($value)
    {
        return value_fallback($value, function () {
            return $this->options['display_name_plural'] = Str::plural($this->display_name_singular);
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
        return value_fallback($value, function () {
            return  $this->options['field_set'] = $this->describeTable()->map(function ($def) {
                return new DataTypeField($def);
            })->values()->all();
        });
    }

    public function getScopesOption($value)
    {
        $value = value_fallback($value, function () {
            return $this->options['scopes'] = [];
        });
        if (is_string($value)) {
            $value = explode(',', $value);
        }

        return $value ?? [];
    }

    public function getRelationsOption($value)
    {
        return value_fallback($value, function () {
            return $this->getRelations($this);
        });
    }

    public function getIconClassOption($value)
    {
        return value_fallback($value, 'mdi mdi-link');
    }

    public function getColumnLabel($column)
    {
        return Str::ucfirst(str_replace('_', ' ', $column));
    }

    protected function describeTable($hidden = false, $timestamps = false)
    {
        $model = app($this->model_name);
        $table = DatabaseSchemaManager::describeTable($model->getTable());
        if (!$hidden) {
            $table = $table->except($model->getHidden())->except($model->getKeyName());
        }
        if (!$timestamps) {
            $table = $table->except([$model::CREATED_AT, $model::UPDATED_AT]);
        }

        return $table;
    }

    public function removeRelationshipFields($action = 'index')
    {
        $related_cols = array_keys($this->relations);

        $forgetKeys = [];
        foreach ($this->list_display as $key => $column) {
            if (in_array($column, $related_cols)) {
                array_push($forgetKeys, $key);
            }
        }
        $this->list_display = collect($this->list_display)->except($forgetKeys)->all();

        $forgetKeys = [];
        foreach ($this->field_set as $key => $field) {
            if (in_array($field->name, $related_cols)) {
                array_push($forgetKeys, $key);
                $field = $this->field_set[$key];
                $field->type = 'select_dropdown';
                $field->display_name = $this->relations[$field->name]['name'];
                $field->relationship = $this->relations[$field->name];

                $field->options = $this->relations[$field->name]['related']->all()->map(function (Model $model) {
                    return [
                        'value' => $model->getKey(),
                        'label' => strval($model),
                    ];
                })->all();

                $fieldSet = $this->field_set;
                $fieldSet[$key] = $field;
                $this->field_set = $fieldSet;
            }
        }
    }
}
