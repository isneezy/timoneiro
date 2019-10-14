<?php

namespace Isneezy\Timoneiro\Actions;

use Illuminate\Database\Eloquent\Model;
use Isneezy\Timoneiro\DataType\AbstractDataType;
use Isneezy\Timoneiro\DataType\DataType;

abstract class AbstractAction implements ActionInterface
{
    /**
     * @var DataType
     */
    protected $dataType;
    /**
     * @var Model
     */
    protected $data;

    /**
     * AbstractAction constructor.
     *
     * @param AbstractDataType $dataType
     * @param Model $data
     */
    public function __construct(AbstractDataType $dataType, $data)
    {
        $this->dataType = $dataType;
        $this->data = $data;
    }

    public function getDataType(): string
    {
        return $this->dataType->slug;
    }

    public function getPolicy()
    {
    }

    public function getRoute($key)
    {
        if (method_exists($this, $method = 'get'.ucfirst($key).'Route')) {
            return $this->{$method}();
        } else {
            return $this->getDefaultRoute();
        }
    }

    public function getAttributes()
    {
        return [];
    }

    public function convertAttributesToHtml()
    {
        $result = '';
        foreach ($this->getAttributes() as $key => $attribute) {
            $result .= $key.'="'.$attribute.'"';
        }

        return $result;
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug === $this->getDataType() || $this->getDataType() === null;
    }
}
