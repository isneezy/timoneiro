<?php

namespace Isneezy\Timoneiro\DataType;

use Illuminate\Support\Str;
use Isneezy\Timoneiro\Facades\Timoneiro;
use Isneezy\Timoneiro\Models\Role;

class RoleDataType extends AbstractDataType
{
    public $model_name = Role::class;
    public $icon_class = 'mdi mdi-lock';
    public $list_display = ['name', 'display_name'];
    public $rules = [
        'name'         => 'required|unique:roles|alpha_dash|max:254',
        'display_name' => 'required|max:254',
    ];

    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }

    public function getFieldSetOption($value)
    {
        $filed = $this->options['field_set']['permissions'];
        $permissions = Timoneiro::permissions(true)->map(function ($permissions) {
            return array_map(function ($permission) {
                return [
                    'value' => $permission,
                    'label' => Str::ucfirst(str_replace('_', ' ', $permission)),
                ];
            }, $permissions);
        });

        $this->options['field_set']['permissions'] = array_merge($filed, [
            'type'    => 'select_multiple',
            'options' => $permissions,
        ]);

        return parent::getFieldSetOption($this->options['field_set']);
    }
}
