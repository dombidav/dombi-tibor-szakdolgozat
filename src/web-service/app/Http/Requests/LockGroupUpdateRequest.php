<?php

namespace App\Http\Requests;

use App\Models\LockGroup;

class LockGroupUpdateRequest extends ApiResourceRequest
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
        return LockGroup::class;
    }
}
