<?php

namespace App\Http\Requests;

use App\Models\Worker;
use App\Rules\Phonenumber;

class WorkerRequest extends ApiResourceRequest
{
    /** @inheritDoc */
    public function rules(): array
    {
        return
            request()->method === 'DELETE'
                ? []
                : [
                'name' => ['required', 'min:3'],
                'rfid' => ['min:4'],
                'birthdate' => ['required'],
                'telephone' => ['min:6', new Phonenumber()],
            ];
    }

    protected function getModel(): string
    {
        return Worker::class;
    }
}
