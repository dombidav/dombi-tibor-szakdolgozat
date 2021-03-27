<?php

namespace App\Http\Requests;

use App\Utils\Bouncer;
use Illuminate\Foundation\Http\FormRequest;

class WorkerGroupAttachRequest extends GroupRequest
{
    public function rules(): array
    {
        return [
            'worker_id' => ['required', 'exists:workers,id'],
            'group_id' => ['required', 'exists:groups,id']
        ];
    }
}
