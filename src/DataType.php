<?php

namespace Isneezy\Timoneiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Isneezy\Timoneiro\Database\DatabaseSchemaManager;
use isneezy\timoneiro\Http\Controllers\TimoneiroBaseController;

/**
 * @property string slug
 * @property array list_display
 */
class DataType extends AbstractDataType
{
    protected $options;
    public $model_name;
    public $order_column;
    public $scopes = [];
    public $display_name_plural;

    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function iconClass()
    {
        return Arr::get($this->options, 'icon-class', 'mdi mdi-link');
    }

    public function label()
    {
        return $this->options['slug'];
    }

    public function slug()
    {
        return $this->slug;
    }

    public function routes($id = null)
    {
        $prefix = 'timoneiro.' . $this->slug() . '.';
        return [
            'browse' => route($prefix . 'index'),
            'read' => route($prefix . 'show', compact('id')),
            'update' => route($prefix . 'update', compact('id')),
            'delete' => route($prefix . 'destroy', compact('id'))
        ];
    }

    public function controller()
    {
        $controller = Arr::get($this->options, 'controller', TimoneiroBaseController::class);
        return Str::start($controller, '\\');
    }

    public function getListDisplayOption($value)
    {
        if (!$value) {
            /** @var Model $model */
            $model = app($this->model_name);
            $this->options['list_display'] = DatabaseSchemaManager::describeTable($model->getTable())
                ->except($model->getHidden())
                ->keys()
                ->all();
        }
        return $value ?: $this->options['list_display'];
    }

    /**
     * @param $key
     * @param $options array | string
     * @return DataType
     */
    public static function make($key, $options)
    {
        if (is_string($options)) {
            $options = ['model' => $options];
        }

        $options['slug'] = Str::kebab(Str::plural(Arr::get($options, 'slug', $key)));

        $dataType = new DataType();
        $dataType->setOptions($options);
        $dataType->model_name = $options['model'];
        $dataType->display_name_plural = $dataType->label();
        return $dataType;
    }
}
