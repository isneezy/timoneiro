<?php

namespace Isneezy\Timoneiro\Http;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Isneezy\Timoneiro\DataType\AbstractDataType;

class Request extends FormRequest
{
    /** @var AbstractDataType */
    protected $dataType;

    /** @var string */
    protected $action;
    protected $model;

    /**
     * @param AbstractDataType $dataType
     *
     * @return $this
     */
    public function attachDataType(AbstractDataType $dataType)
    {
        $this->dataType = $dataType;

        return $this;
    }

    /**
     * @param string $action
     * @param null   $model
     */
    public function check($action, $model = null)
    {
        $this->action = $action;
        $this->model = $model ?? app($this->dataType->model_name);
        $this->validateResolved();
    }

    /**
     * @return AbstractDataType
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function authorize()
    {
        return $this->user()->can($this->action, $this->model);
    }

    public function rules()
    {
        $paramName = Str::snake(Str::camel(Str::singular($this->dataType->slug)));
        $id = $this->route($paramName);
        $table = app($this->dataType->model_name)->getTable();
        $isUpdate = $this->action === 'edit' && $id;

        if ($this->isMethod('get') || $this->isMethod('delete')) {
            return [];
        }

        $rules = $this->parseRules($this->dataType, $isUpdate, $table, $id);
        if (is_string($rules) && class_exists($rules)) {
            app($rules);

            return [];
        }

        return $rules;
    }

    protected function parseRules($dataType, $isUpdate, $table, $id)
    {
        $rules = $dataType->rules ?? [];
        if ($isUpdate) {
            $rules = $dataType->update_rules ?? $rules;
        } else {
            $rules = $dataType->store_rules ?? $rules;
        }
        if (is_string($rules) && class_exists($rules)) {
            return $rules;
        }

        return collect($rules)->map(function ($rules) use ($id, $table, $isUpdate) {
            $rules = is_array($rules) ? $rules : explode('|', $rules);
            foreach ($rules as &$fieldRule) {
                // fix unique
                if ($isUpdate && is_string($fieldRule) && Str::contains($fieldRule, 'unique:')) {
                    $fieldRule = Rule::unique($table)->ignore($id);
                }
            }

            return $rules;
        })->all();
    }
}
