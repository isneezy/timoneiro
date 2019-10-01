<?php

namespace Isneezy\Timoneiro\DataType;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Isneezy\Timoneiro\DataType\Traits\HasOptions;

/**
 * Class DataTypeField
 * @package Isneezy\Timoneiro\DataType
 * @property string name
 * @property string display_name
 */
class DataTypeField
{
    use HasOptions;

    protected static $types = [
        'date' => ['datetime'],
        'number' => ['bigint', 'int', 'integer'],
        'text' => ['string']
    ];

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function getDisplayNameOption($value) {
        $name = value_fallback($value, $this->name);
        return Str::title(str_replace('_', ' ', $name));
    }

    public function getPlaceHolderOption($value) {
        return $this->getDisplayNameOption($value);
    }

    public function getTypeOption($type) {
        $result = [];
        foreach (self::$types as $key => $value) {
            foreach ($value as $item) {
                $result[$item] = $key;
            }
        }
        return Arr::get($result, $type, $type);
    }
}
