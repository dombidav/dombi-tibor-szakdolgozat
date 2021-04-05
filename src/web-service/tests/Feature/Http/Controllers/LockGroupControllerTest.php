<?php

namespace Http\Controllers;

use App\Http\Resources\LockGroupResource;
use App\Models\LockGroup;
use Tests\TestCase;

class LockGroupControllerTest extends TestCase
{
    public function testLockGroupIndex(): void
    {
        $this->assertModel('lock-group.index', LockGroupResource::make(LockGroup::first()), [], LockGroup::count());
    }

    public function testLockGroupShow(): void
    {
        $this->assertModel('lock-group.show', LockGroupResource::make(LockGroup::first()), ['lock_group' => LockGroup::first()->id]);
    }

    public function testLockGroupCreate(): void
    {
        $this->withoutExceptionHandling();
        $requestModel = [
            'name' => 'Test LockGroup',
        ];

        $this->assertPermissionCanCreate('admin', 'lock_group', $requestModel, $requestModel);
    }

    public function testLockGroupUpdate(): void
    {
        $this->assertPermissionCanUpdate('admin', 'lock_group', ['name' => 'Updated LockGroup'], LockGroup::latestOne());
    }

    public function testLockGroupDelete(): void
    {
        $this->assertPermissionCanDelete('admin', 'lock_group', LockGroup::first());
    }
}
