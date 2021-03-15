<?php

namespace App\Http\Requests;

use App\Models\User;

class UserRequest extends ApiResourceRequest
{
    /** @inheritDoc */
    public function rules(): array
    {
        return
            request()->method === 'DELETE'
                ? []
                : [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'password_confirmation' => 'required_with:password|same:password'
            ];
    }

    protected function getModel(): string
    {
        return User::class;
    }
}
