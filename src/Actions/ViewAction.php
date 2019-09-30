<?php
namespace Isneezy\Timoneiro\Actions;


class ViewAction extends AbstractAction
{

    public function getTitle(): ?string
    {
        return 'View';
    }

    public function getAttributes()
    {
        return [
            'class' => 'inline-block px-1 text-gray-500 hover:text-gray-700'
        ];
    }

    public function getIcon(): ?string
    {
        return 'mdi mdi-eye';
    }

    public function getDefaultRoute()
    {
        return route('timoneiro.'.$this->getDataType().'.show', $this->data->{$this->data->getKeyName() });
    }
}
