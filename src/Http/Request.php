<?php
namespace Isneezy\Timoneiro\Http;


use Isneezy\Timoneiro\DataType\AbstractDataType;

class Request extends \Illuminate\Http\Request
{
    /** @var AbstractDataType */
    protected $dataType;

    /**
     * @param AbstractDataType $dataType
     * @return $this
     */
    public function attachDataType(AbstractDataType $dataType) {
        $this->dataType = $dataType;
        return $this;
    }

    /**
     * @return AbstractDataType
     */
    public function getDataType() {
        return $this->dataType;
    }
}