<?php

namespace Http\Controllers;

use App\Http\Resources\AccessRuleResource;
use App\Models\AccessRule;
use Tests\TestCase;

class AccessRuleControllerTest extends TestCase
{
    public function testAccessRuleIndex(): void
    {
        $this->assertModel('accessrule.index', AccessRuleResource::make(AccessRule::first()), [], AccessRule::count());
    }

    public function testAccessRuleShow(): void
    {
        $this->assertModel('accessrule.show', AccessRuleResource::make(AccessRule::first()), ['accessrule' => AccessRule::first()->id]);
    }

    public function testAccessRuleCreate(): void
    {
        $this->withoutExceptionHandling();
        $requestModel = [
            'name' => 'Test AccessRule',
            //TODO: Complete definition
        ];

        $this->assertPermissionCanCreate('admin', 'accessrule', $requestModel, $requestModel);
    }

    public function testAccessRuleUpdate(): void
    {
        $this->assertPermissionCanUpdate('admin', 'accessrule', ['name' => 'Updated AccessRule'], AccessRule::latestOne());
    }

    public function testAccessRuleDelete(): void
    {
        $this->assertPermissionCanDelete('admin', 'accessrule', AccessRule::first());
    }
}
