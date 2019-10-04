<?php

namespace Isneezy\Timoneiro\Actions;

class EditAction extends AbstractAction
{
    public function getTitle(): ?string
    {
        return 'Edit';
    }

    public function getIcon(): ?string
    {
        return 'mdi mdi-square-edit-outline';
    }

    public function getPolicy()
    {
        // return 'edit';
    }

    public function getAttributes()
    {
        return [
            'class' => 'inline-block px-1 text-gray-500 hover:text-warning',
        ];
    }

    public function getDefaultRoute()
    {
        return route('timoneiro.'.$this->dataType->slug.'.edit', $this->data->{$this->data->getKeyName()});
    }
}
