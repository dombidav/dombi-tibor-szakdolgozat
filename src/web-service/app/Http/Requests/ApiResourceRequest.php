<?php

namespace App\Http\Requests;

use App\Utils\Bouncer;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiResourceRequest extends FormRequest
{
    abstract protected function getModel():string;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return request()->method === 'GET' || Bouncer::can('manage', $this->getModel());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules(): array;
}
