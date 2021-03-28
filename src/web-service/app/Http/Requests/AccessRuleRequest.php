<?php

namespace App\Http\Requests;

use App\Models\AccessRule;

class AccessRuleRequest extends ApiResourceRequest
{
    /** @inheritDoc */
    public function rules(): array
    {
        return
            request()->method === 'DELETE'
                ? []
                : [
                'name' => ['required', 'min:3'],
                //TODO: Complete definition
            ];
    }

    protected function getModel(): string
    {
        return AccessRule::class;
    }
}
