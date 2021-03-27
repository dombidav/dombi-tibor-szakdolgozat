<?php

namespace App\Http\Requests;

use App\Models\Group;

class GroupUpdateRequest extends ApiResourceRequest
{
    /** @inheritDoc */
    public function rules(): array
    {
        return
            [
                'name' => ['min:3'],
            ];
    }

    protected function getModel(): string
    {
        return Group::class;
    }
}
