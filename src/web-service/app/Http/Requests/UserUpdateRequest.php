<?php

namespace App\Http\Requests;

use App\Models\User;

class UserUpdateRequest extends ApiResourceRequest
{
    /** @inheritDoc */
    public function rules(): array
    {
        return [
            'name' => 'min:3',
            'email' => 'email|unique:users',
            'password' => 'min:6',
            'password_confirmation' => 'required_with:password|same:password',
            'old_password' => 'required_with:password|password'
        ];
    }

    protected function getModel(): string
    {
        return User::class;
    }
}
