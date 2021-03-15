<?php

namespace App\Http\Requests;

use App\Models\Worker;
use App\Rules\Phonenumber;

class WorkerUpdateRequest extends ApiResourceRequest
{
    /** @inheritDoc */
    public function rules(): array
    {
        return
            [
                'name' => ['min:3'],
                'rfid' => ['min:4'],
                'birthdate' => [],
                'telephone' => ['min:6', new Phonenumber()],
            ];
    }

    protected function getModel(): string
    {
        return Worker::class;
    }
}
