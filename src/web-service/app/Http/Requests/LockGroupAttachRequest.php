<?php

namespace App\Http\Requests;

use App\Utils\Bouncer;
use Illuminate\Foundation\Http\FormRequest;

class LockGroupAttachRequest extends TeamRequest
{
    public function rules(): array
    {
        return [
            'lock_id' => ['required', 'exists:locks,id'],
            'lock_group_id' => ['required', 'exists:lock_groups,id']
        ];
    }
}
