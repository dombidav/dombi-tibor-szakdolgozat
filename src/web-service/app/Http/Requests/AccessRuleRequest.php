<?php

namespace App\Http\Requests;

use App\Models\AccessRule;
use App\Rules\ValidateRuleDefinition;

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
                'description' => ['required'],
                'definition' => [new ValidateRuleDefinition()],
            ];
    }

    protected function getModel(): string
    {
        return AccessRule::class;
    }
}
