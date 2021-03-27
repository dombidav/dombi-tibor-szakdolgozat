<?php

namespace Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    public function testGroupIndex(): void
    {
        $this->assertModel('group.index', GroupResource::make(Group::first()), [], Group::count());
    }

    public function testGroupShow(): void
    {
        $this->assertModel('group.show', GroupResource::make(Group::first()), ['group' => Group::first()->id]);
    }

    public function testGroupCreate(): void
    {
        $this->withoutExceptionHandling();
        $requestModel = [
            'name' => 'Test Group',
        ];

        $this->assertPermissionCanCreate('admin', 'group', $requestModel, $requestModel);
    }

    public function testGroupUpdate(): void
    {
        $this->assertPermissionCanUpdate('admin', 'group', ['name' => 'Updated Group'], Group::latestOne());
    }

    public function testGroupDelete(): void
    {
        $this->assertPermissionCanDelete('admin', 'group', Group::first());
    }
}
