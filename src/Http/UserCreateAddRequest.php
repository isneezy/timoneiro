<?php

namespace Isneezy\Timoneiro\Http;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCreateAddRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('user');
        $password = 'min:6|confirmed';

        if ($this->getTimoneiroRequest()->getAction() !== 'edit') {
            $password = "required|{$password}";
        } else {
            $password = "nullable|{$password}";
        }

        return [
            'role_id'     => 'required|exists:roles,id',
            'name'        => 'required',
            'email'       => ['required', 'email', Rule::unique('users')->ignore($id)],
            'verified_at' => 'sometimes|datetime',
            'password'    => $password,
        ];
    }

    /**
     * @return Request
     */
    public function getTimoneiroRequest()
    {
        return app(Request::class);
    }
}
