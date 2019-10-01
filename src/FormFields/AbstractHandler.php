<?php

namespace Isneezy\Timoneiro\FormFields;


use Illuminate\Support\Str;
use Isneezy\Timoneiro\Traits\Renderable;

class AbstractHandler implements HandlerInterface
{
    use Renderable;

    protected $name;
    protected $codename;
    protected $supports = [];

    public function handle($field, $dataType, $data)
    {
        $content = $this->createContent($field, $dataType, $data);
        return $this->render($content);
    }

    public function supports($driver)
    {
        if (empty($this->supports)){
            return true;
        }

        return in_array($driver, $this->supports);
    }

    public function getCodename()
    {
        if (empty($this->codename)) {
            $name = class_basename($this);
            if (Str::endsWith($name, 'Handler')) {
                $name = substr($name, 0, -strlen('Handler'));
            }
            $this->codename = Str::snake($name);
        }

        return $this->codename;
    }

    public function getName()
    {
        if (empty($this->name)) {
            $this->name = ucwords(str_replace('_', ' ', $this->getCodename()));
        }
        return $this->name;
    }


    public function createContent($field, $dataType, $data) {
        return view('timoneiro::formfields.'.$this->getCodename(), compact(
            'field',
            'dataType',
            'data'
        ));
    }
}
