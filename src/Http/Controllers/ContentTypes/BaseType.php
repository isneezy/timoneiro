<?php

namespace Isneezy\Timoneiro\Http\Controllers\ContentTypes;

use Illuminate\Http\Request;
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

    public function __construct(array $data, $slug, $field)
    {
        $this->slug = $slug;
        $this->field = $field;
        $this->data = $data;
    }

    abstract public function handle();
}
