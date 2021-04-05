<?php

namespace App\Http\Requests;

use App\Models\LockGroup;

class LockGroupRequest extends ApiResourceRequest
{
    /** @inheritDoc */
    public function rules(): array
    {
        return
            request()->method === 'DELETE'
                ? []
                : [
                'name' => ['required', 'min:3'],
            ];
    }

    protected function getModel(): string
    {
        return LockGroup::class;
    }
}
