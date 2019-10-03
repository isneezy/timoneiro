<?php

namespace Isneezy\Timoneiro\FormFields;


class SelectDropdownHandler extends AbstractHandler
{
    public function createContent($field, $dataType, $data) {
        return view('timoneiro::formfields.'.$this->getCodename(), compact(
            'field',
            'dataType',
            'data'
        ));
    }
}
