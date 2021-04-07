<?php

namespace App\Http\Requests;

class RuleAttachRequest extends AccessRuleRequest
{
    public function rules(): array
    {
        return [
            'access_rule_id' => ['required', 'exists:access_rules,id'],
            'team_id' => ['required_without:lock_group_id', 'exists:teams,id'],
            'lock_group_id' => ['required_without:team_id', 'exists:lock_groups,id'],
        ];
    }
}
