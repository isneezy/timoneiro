<?php

namespace Isneezy\Timoneiro\Actions;

use Illuminate\Database\Eloquent\SoftDeletes;

class DeleteAction extends AbstractAction
{
    public function getTitle(): ?string
    {
        return 'Delete';
    }

    public function getIcon(): ?string
    {
        return 'mdi mdi-delete';
    }

    public function getAttributes()
    {
        return [
            'class'       => 'inline-block px-1 text-gray-500 hover:text-danger delete-single',
            'data-id'     => $this->data->getKey(),
            'data-action' => route("timoneiro.{$this->dataType->slug}.destroy", $this->data->getKey()),
            'id'          => 'delete-'.$this->data->getKey(),
        ];
    }

    public function getDefaultRoute()
    {
        return 'javascript:void(0)';
    }

    public function shouldActionDisplayOnDataType()
    {
        if ($this->data && in_array(SoftDeletes::class, class_uses(get_class($this->data))) && $this->data->deleted_at) {
            return false;
        }

        return parent::shouldActionDisplayOnDataType();
    }
}
