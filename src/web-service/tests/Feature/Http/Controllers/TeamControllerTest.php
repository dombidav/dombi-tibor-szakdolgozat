<?php

namespace Http\Controllers;

use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Models\Worker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class TeamControllerTest extends TestCase
{
    public function testTeamIndex(): void
    {
        $this->assertModel('team.index', TeamResource::make(Team::first()), [], Team::count());
    }

    public function testTeamShow(): void
    {
        $this->assertModel('team.show', TeamResource::make(Team::first()), ['team' => Team::first()->id]);
    }

    public function testTeamCreate(): void
    {
        $this->withoutExceptionHandling();
        $requestModel = [
            'name' => 'Test Team',
        ];

        $this->assertPermissionCanCreate('admin', 'team', $requestModel, $requestModel);
    }

    public function testTeamUpdate(): void
    {
        $this->assertPermissionCanUpdate('admin', 'team', ['name' => 'Updated Team'], Team::latestOne());
    }

    public function testTeamDelete(): void
    {
        $this->assertPermissionCanDelete('admin', 'team', Team::first());
    }

    public function testTeamAttach(): void
    {
        $this->withoutExceptionHandling();
        /** @var Team $team */
        $team = Team::random();
        $numTeam = $team->workers()->count();
        /** @var Worker $worker */
        $worker = Worker::random();
        $numWorkers = $worker->teams()->count();
        $response = $this->actingAs($this->users['admin'])->post(route('team.attach'), ['team_id' => $team->id, 'worker_id' => $worker->id], ['Accept' => 'application/json']);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $worker->refresh();
        $team->refresh();

        self::assertEquals($numWorkers + 1, $worker->teams()->count());
        self::assertEquals($numTeam + 1, $team->workers()->count());
    }

    public function testTeamDetach(): void
    {
        /** @var Team $team */
        $team = Team::random();
        $numTeam = $team->workers()->count();
        /** @var Worker $worker */
        $worker = $team->workers()->inRandomOrder()->first();
        $numWorkers = $worker->teams()->count();
        $response = $this->actingAs($this->users['admin'])->delete(route('team.detach'), ['team_id' => $team->id, 'worker_id' => $worker->id], ['Accept' => 'application/json']);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $worker->refresh();
        $team->refresh();

        self::assertEquals($numWorkers - 1, $worker->teams()->count());
        self::assertEquals($numTeam - 1, $team->workers()->count());
    }
}
