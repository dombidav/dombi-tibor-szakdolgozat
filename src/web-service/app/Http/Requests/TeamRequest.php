<?php

namespace App\Http\Requests;

use App\Models\Team;

class TeamRequest extends ApiResourceRequest
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
        return Team::class;
    }
}
