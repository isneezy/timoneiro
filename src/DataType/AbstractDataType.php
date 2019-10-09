<?php

namespace Isneezy\Timoneiro\DataType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
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
 * @property string display_name_plural
 * @property string icon_class
 * @property array list_display
 * @property array scopes
 * @property array field_set
 * @property array relations
 * @property string default
 * @property array | null short_descriptions
 * @property FormRequest | array | null rules
 * @property FormRequest | array | null update_rules
 * @property FormRequest | array | null create_rules
 */
class AbstractDataType
{
    use HasOptions, RelationShipParser;

    protected $table = [];

    public function __construct(array $options = [])
    {
        $this->options = array_merge_recursive($options, $this->options);

        try {
            $order = 0;
            $this->describeTable()->each(function ($def, $key) use (&$order) {
                $order += 100;
                $opts = Arr::get($this->options, "field_set.{$key}", []);
                $opts['order'] = Arr::get($opts, 'order', $order);
                $this->options['field_set'][$key] = array_merge($opts, $def, $opts);
            });
        } catch (\Throwable $e) {
            Log::error($e->getMessage(), [$e->getTraceAsString()]);
        }
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
        return collect($value)->map(function ($def) {
            if (!$def instanceof DataTypeField) {
                $def = new DataTypeField($def);
            }
            return $def;
        })->sortBy(function ($def) {
            return $def->order;
        })->all();
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
        if ($this->short_descriptions) {
            $column = Arr::get($this->short_descriptions, $column, $column);
        }
        return Str::ucfirst(str_replace('_', ' ', $column));
    }

    protected function describeTable($hidden = false, $timestamps = false)
    {
        if (empty($this->table)) {
            $model = app($this->model_name);
            $table = DatabaseSchemaManager::describeTable($model->getTable());
            if (!$hidden) {
                $table = $table->except($model->getHidden())->except($model->getKeyName());
            }
            if (!$timestamps) {
                $table = $table->except([$model::CREATED_AT, $model::UPDATED_AT]);
            }

            $this->table = $table;
        }
        return $this->table;
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
                $field->display_name = $field->display_name ?? $this->relations[$field->name]['name'];
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
