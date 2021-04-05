<?php

namespace App\Http\Requests;

use App\Models\Team;

class TeamUpdateRequest extends ApiResourceRequest
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
        return Team::class;
    }
}
