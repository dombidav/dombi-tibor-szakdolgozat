<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->method === 'GET' || Bouncer::can('manage', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(request()->method === 'DELETE'){
            $rules = [];
        }else{
            $required = (request()->method === 'PUT') ? '' : 'required|';
            $rules = [
                'name' => "${required}min:3",
                'email' => "${required}email|unique:users",
                'password' => "${required}min:6",
                'password_confirmation' => 'required_with:password|same:password'
            ];
            if(request()->method === 'PUT'){
                $rules['old_password'] = 'required_with:password|password';
            }
        }
        return $rules;
    }
}
