<?php

namespace App\Http\Requests;

use App\Models\Lock;
use Illuminate\Foundation\Http\FormRequest;

class AccessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $device_key = $this->request->get('device_key');
        $device = Lock::where('device_key',  $device_key)->first() ?? Lock::find($device_key);
        /** @noinspection NullPointerExceptionInspection */
        return $device?->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'worker_id' => ['required_without:worker_rfid'],
            'worker_rfid' => ['required_without:worker_id']
        ];
    }
}
