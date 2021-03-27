<?php

namespace Http\Controllers;

use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\Worker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

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

    public function testGroupAttach(): void
    {

        /** @var Worker $worker */
        $worker = Worker::random();
        $numWorkers = $worker->groups()->count();
        /** @var Group $group */
        $group = Group::random();
        $numGroup = $group->workers()->count();
        $response = $this->actingAs($this->users['admin'])->post(route('group.attach'), ['group_id' => $group->id, 'worker_id' => $worker->id], ['Accept' => 'application/json']);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $worker->refresh();
        $group->refresh();

        self::assertEquals($numWorkers + 1, $worker->groups()->count());
        self::assertEquals($numGroup + 1, $group->workers()->count());
    }
}
