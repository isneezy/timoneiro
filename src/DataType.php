<?php

namespace Isneezy\Timoneiro;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class DataType
 * @package Isneezy\Timoneiro
 */
class DataType extends AbstractDataType
{
    /**
     * @param $key
     * @param $options array | string
     * @return DataType
     */
    public static function make($key, $options)
    {
        if (is_string($options)) {
            $options = ['model_name' => $options];
        }

        $options['slug'] = value_fallback(
            Arr::get($options, 'slug'),
            Str::kebab(Str::plural(Arr::get($options, 'slug', $key)))
        );

        $dataType = new DataType($options);
        return $dataType;
    }
}
