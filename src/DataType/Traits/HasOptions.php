<?php

namespace Isneezy\Timoneiro\DataType\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasOptions
{
    protected $options = [];

    public function getOption($name)
    {
        $value = Arr::get($this->options, $name);
        $getter = Str::camel("get_$name".'_option');
        if (method_exists($this, $getter)) {
            $value = $this->{$getter}($value);
        }

        return $value;
    }

    public function setOption($name, $value)
    {
        $setter = Str::camel("set_$name".'_option');
        if (method_exists($this, $setter)) {
            $this->{$setter}($value);
        } else {
            $this->options[$name] = $value;
        }
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function __get($name)
    {
        return $this->getOption($name);
    }

    public function __set($name, $value)
    {
        $this->setOption($name, $value);
    }
}
