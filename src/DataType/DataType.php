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
     * @param $slug
     * @param $options array | string
     *
     * @return DataType
     */
    public static function make($slug, $options)
    {
        if (is_string($options)) {
            $options = ['model_name' => $options];
        }

        $options['slug'] = value_fallback(
            Arr::get($options, 'slug'),
            Str::kebab(Str::plural($slug))
        );

        $dataType = new self($options);

        return $dataType;
    }
}
