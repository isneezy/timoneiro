<?php

namespace Isneezy\Timoneiro\Http\Controllers\ContentTypes;

use Illuminate\Database\Eloquent\Model;
use Isneezy\Timoneiro\DataType\DataTypeField;

abstract class BaseType
{
    protected $slug;
    /**
     * @var DataTypeField
     */
    protected $field;
    /**
     * @var array
     */
    protected $data;

    /** @var Model */
    protected $model;

    public function __construct(array $data, $slug, $field, $model)
    {
        $this->slug = $slug;
        $this->field = $field;
        $this->data = $data;
        $this->model = $model;
    }

    abstract public function handle();
}
