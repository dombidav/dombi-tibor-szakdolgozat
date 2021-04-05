<?php

namespace Http\Controllers;

use App\Http\Resources\AccessRuleResource;
use App\Models\AccessRule;
use Tests\TestCase;
//TODO: Fix test cases
//class AccessRuleControllerTest extends TestCase
//{
//    public function testAccessRuleIndex(): void
//    {
//        $this->assertModel('rule.index', AccessRuleResource::make(AccessRule::first()), [], AccessRule::count());
//    }
//
//    public function testAccessRuleShow(): void
//    {
//        $this->assertModel('rule.show', AccessRuleResource::make(AccessRule::first()), ['rule' => AccessRule::first()->id]);
//    }
//
//    public function testAccessRuleCreate(): void
//    {
//        $this->withoutExceptionHandling();
//        $requestModel = [
//            'name' => 'Test AccessRule',
//            //TODO: Complete definition
//        ];
//
//        $this->assertPermissionCanCreate('admin', 'rule', $requestModel, $requestModel);
//    }
//
//    public function testAccessRuleUpdate(): void
//    {
//        $this->assertPermissionCanUpdate('admin', 'rule', ['name' => 'Updated AccessRule'], AccessRule::latestOne());
//    }
//
//    public function testAccessRuleDelete(): void
//    {
//        $this->assertPermissionCanDelete('admin', 'rule', AccessRule::first());
//    }
//}
