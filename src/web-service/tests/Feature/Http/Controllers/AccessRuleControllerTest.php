<?php

namespace Http\Controllers;

use App\Http\Resources\AccessRuleResource;
use App\Models\AccessRule;
use App\Models\Lock;
use App\Models\LockGroup;
use App\Models\Team;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Tests\TestCase;

class AccessRuleControllerTest extends TestCase
{
    public function testAccessRuleIndex(): void
    {
        $this->assertModel('access_rule.index', AccessRuleResource::make(AccessRule::first())->toJson(), [], AccessRule::count());
    }

    public function testAccessRuleShow(): void
    {
        $this->assertModel('access_rule.show', AccessRuleResource::make(AccessRule::first())->toJson(), ['access_rule' => AccessRule::first()->id]);
    }

    public function testAccessRuleCreate(): void
    {
        $this->withoutExceptionHandling();
        $requestModel = [
            'name' => 'Test AccessRule',
            'description' => 'This is a test Rule',
            'definition' => [
                'on' => '2021-04-20',
                'action' => 'allow'
            ]
        ];

        $this->assertPermissionCanCreate('admin', 'access_rule', $requestModel, $requestModel);
    }

    public function testAccessRuleUpdate(): void
    {
        $this->assertPermissionCanUpdate('admin', 'access_rule', ['name' => 'Updated AccessRule'], AccessRule::latestOne());
    }

    public function testAccessRuleDelete(): void
    {
        $this->assertPermissionCanDelete('admin', 'access_rule', AccessRule::first());
    }
}
