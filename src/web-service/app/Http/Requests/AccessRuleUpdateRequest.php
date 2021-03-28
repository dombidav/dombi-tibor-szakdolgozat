<?php

namespace App\Http\Requests;

use App\Models\AccessRule;

class AccessRuleUpdateRequest extends ApiResourceRequest
{
    /** @inheritDoc */
    public function rules(): array
    {
        return
            [
                'name' => ['min:3'],
                //TODO: Complete definition
            ];
    }

    protected function getModel(): string
    {
        return AccessRule::class;
    }
}
