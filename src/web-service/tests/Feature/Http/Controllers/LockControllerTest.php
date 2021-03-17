<?php

namespace Http\Controllers;

use App\Http\Resources\LockResource;
use App\Models\Lock;
use Tests\TestCase;

class LockControllerTest extends TestCase
{
    public function testLockIndex(): void
    {
        $this->assertModel('lock.index', LockResource::make(Lock::first()), [], Lock::count());
    }

    public function testLockShow(): void
    {
        $this->assertModel('lock.show', LockResource::make(Lock::first()), ['lock' => Lock::first()->id]);
    }

    public function testLockCreate(): void
    {
        $this->withoutExceptionHandling();
        $this->assertPermissionCanCreate('admin', 'lock', ['name' => 'Test Lock', 'status' => 2], ['name' => 'Test Lock', 'status' => 2, 'statusText' => 'open']);
    }

    public function testLockUpdate(): void
    {
        $this->assertPermissionCanUpdate('admin', 'lock', ['name' => 'Updated Lock'], Lock::latestOne());
    }

    public function testLockDelete(): void
    {
        $this->assertPermissionCanDelete('admin', 'lock', Lock::first());
    }
}
