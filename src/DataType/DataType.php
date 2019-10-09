<?php

namespace Isneezy\Timoneiro\DataType;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class DataType.
 */
class DataType extends AbstractDataType
{
    /**
     * @param $options array | string
     *
     * @return DataType
     */
    public static function make($options)
    {
        if (is_string($options)) {
            if (class_exists($options)) {
                $model = app($options);
                if ($model instanceof AbstractDataType) {
                    return $model;
                }
            }
            $options = ['model_name' => $options];
        }

        $dataType = new self($options);

        return $dataType;
    }
}
