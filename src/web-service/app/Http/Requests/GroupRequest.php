<?php

namespace App\Http\Requests;

use App\Models\Group;

class GroupRequest extends ApiResourceRequest
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
        return Group::class;
    }
}
