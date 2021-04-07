<?php

namespace Http\Controllers;

use App\Http\Resources\LockGroupResource;
use App\Models\Lock;
use App\Models\LockGroup;
use App\Models\Team;
use App\Models\Worker;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Tests\TestCase;

class LockGroupControllerTest extends TestCase
{
    public function testLockGroupIndex(): void
    {
        $this->assertModel('lock_group.index', LockGroupResource::make(LockGroup::first()), [], LockGroup::count());
    }

    public function testLockGroupShow(): void
    {
        $this->assertModel('lock_group.show', LockGroupResource::make(LockGroup::first()), ['lock_group' => LockGroup::first()->id]);
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

    public function testGroupAttach(): void
    {
        $this->withoutExceptionHandling();
        /** @var LockGroup $group */
        $group = LockGroup::random();
        $numGroup = $group->locks()->count();
        /** @var Lock $lock */
        $lock = Lock::random();
        $numLocks = $lock->groups()->count();
        $response = $this->actingAs($this->users['admin'])->post(route('lock_group.attach'), ['lock_group_id' => $group->id, 'lock_id' => $lock->id], ['Accept' => 'application/json']);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $lock->refresh();
        $group->refresh();

        self::assertEquals($numLocks + 1, $lock->groups()->count());
        self::assertEquals($numGroup + 1, $group->locks()->count());
    }

    public function testGroupDetach(): void
    {
        /** @var LockGroup $group */
        $group = LockGroup::random();
        $numGroup = $group->locks()->count();
        /** @var Lock $lock */
        do{
            $lock = $group->locks()->inRandomOrder()->first();
        }while(!$lock);
        $numLocks = $lock->groups()->count();
        $response = $this->actingAs($this->users['admin'])->delete(route('lock_group.detach'), ['lock_group_id' => $group->id, 'lock_id' => $lock->id], ['Accept' => 'application/json']);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $lock->refresh();
        $group->refresh();

        self::assertEquals($numLocks - 1, $lock->groups()->count());
        self::assertEquals($numGroup - 1, $group->locks()->count());
    }
}
