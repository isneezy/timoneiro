<?php

namespace Isneezy\Timoneiro;


use Exception;
use Illuminate\Support\Str;

class AbstractDataType
{
    protected $options = [];

    public function setOptions(array $options) {
        $this->options = $options;
        return $this;
    }

    public function getOption($name)
    {
        $getter = Str::camel("get_$name".'_option');
        try {
            $value = $this->options[$name];
        }catch (Exception $e) {
            $value = null;
        }

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

    public function __get($name)
    {
        return $this->getOption($name);
    }

    public function __set($name, $value)
    {
        $this->setOption($name, $value);
    }
}
