<?php

namespace Http\Controllers;

use App\Http\Resources\AccessRuleResource;
use App\Models\AccessRule;
use App\Models\Lock;
use App\Models\LockGroup;
use App\Models\Team;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Tests\TestCase;

class AccessRuleAttachControllerTest extends TestCase
{

    public function testGroupAttach(): void
    {
        /** @var LockGroup $group */
        $group = LockGroup::factory()->create();
        $group->refresh();

        /** @var AccessRule $rule */
        $rule = AccessRule::factory()->create();
        $rule->refresh();

        $response = $this->actingAs($this->users['admin'])->post(route('rule.attach'), ['lock_group_id' => $group->id, 'access_rule_id' => $rule->id], ['Accept' => 'application/json']);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $group->refresh();
        $rule->refresh();

        self::assertEquals(1, $group->rules()->count());
        self::assertEquals(1, $rule->lockGroups()->count());

        try {
            $group->delete();
        } catch (\Exception) {
        }
        try {
            $rule->delete();
        } catch (\Exception) {
        }
    }

    public function testGroupDetach(): void
    {
        /** @var LockGroup $group */
        $group = LockGroup::factory()->create();
        $group->refresh();

        /** @var AccessRule $rule */
        $rule = AccessRule::factory()->create();
        $rule->refresh();

        $group->rules()->attach($rule->id);

        $response = $this->actingAs($this->users['admin'])->delete(route('rule.detach'), ['lock_group_id' => $group->id, 'access_rule_id' => $rule->id], ['Accept' => 'application/json']);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $group->refresh();
        $rule->refresh();

        self::assertEquals(0, $group->rules()->count());
        self::assertEquals(0, $rule->lockGroups()->count());

        try {
            $group->delete();
        } catch (\Exception) {
        }
        try {
            $rule->delete();
        } catch (\Exception) {
        }
    }

    public function testTeamAttach(): void
    {
        /** @var Team $team */
        $team = Team::factory()->create();
        $team->refresh();

        /** @var AccessRule $rule */
        $rule = AccessRule::factory()->create();
        $rule->refresh();

        $response = $this->actingAs($this->users['admin'])->post(route('rule.attach'), ['team_id' => $team->id, 'access_rule_id' => $rule->id], ['Accept' => 'application/json']);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $team->refresh();
        $rule->refresh();

        self::assertEquals(1, $team->rules()->count());
        self::assertEquals(1, $rule->workerGroups()->count());

        try {
            $team->delete();
        } catch (\Exception) {
        }
        try {
            $rule->delete();
        } catch (\Exception) {
        }
    }

    public function testTeamDetach(): void
    {
        /** @var Team $team */
        $team = Team::factory()->create();
        $team->refresh();

        /** @var AccessRule $rule */
        $rule = AccessRule::factory()->create();
        $rule->refresh();

        $team->rules()->attach($rule->id);

        $response = $this->actingAs($this->users['admin'])->delete(route('rule.detach'), ['team_id' => $team->id, 'access_rule_id' => $rule->id], ['Accept' => 'application/json']);
        $response->assertStatus(ResponseCode::HTTP_NO_CONTENT);

        $team->refresh();
        $rule->refresh();

        self::assertEquals(0, $team->rules()->count());
        self::assertEquals(0, $rule->workerGroups()->count());

        try {
            $team->delete();
        } catch (\Exception) {
        }
        try {
            $rule->delete();
        } catch (\Exception) {
        }
    }
}
