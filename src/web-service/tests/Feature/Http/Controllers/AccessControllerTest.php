<?php

namespace Http\Controllers;

use App\Http\Controllers\AccessController;
use App\Models\AccessRule;
use App\Models\Lock;
use App\Models\LockGroup;
use App\Models\Team;
use App\Models\Worker;
use Illuminate\Support\Str;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class AccessControllerTest extends TestCase
{
    protected static function InitRule(string $action, bool $needsDeviceKey = false, bool $needsWorkerRfid = false): array
    {
        /** @var Worker $worker */
        $worker = Worker::factory($needsWorkerRfid ? ['rfid' => Str::random()] : [])->create();
        /** @var Lock $lock */
        $lock = Lock::factory($needsDeviceKey ? ['device_key' => Str::random(10)] : [])->create();

        /** @var Team $team */
        $team = Team::factory()->create();
        /** @var LockGroup $lock_group */
        $lock_group = LockGroup::factory()->create();

        $worker->teams()->attach($team);
        $worker->save();
        $worker->refresh();
        $lock->groups()->attach($lock_group);
        $lock->save();
        $worker->refresh();

        /** @var AccessRule $rule */
        $rule = AccessRule::factory([
            'definition' => [
                'on' => now()->format('Y-m-d'),
                'action' => '' . $action . ''
            ]
        ]
        )->create();

        $rule->workerGroups()->attach($team);
        $rule->lockGroups()->attach($lock_group);
        $rule->save();
        $rule->refresh();
        return [$worker, $lock, $rule];
    }

    public function testWorkerEnterWithIDOnDeviceIDShouldAllow(){
        [$worker, $lock] = self::InitRule('allow');

        $response = $this->put(route('access.enter', [$lock->id]), ['worker_id' => $worker->id]);
        $response->assertStatus(ResponseCode::HTTP_ACCEPTED);
    }

    public function testWorkerEnterWithIDOnDeviceIDShouldForbid(){
        [$worker, $lock] = self::InitRule('forbid');

        $response = $this->put(route('access.enter', [$lock->id]), ['worker_id' => $worker->id]);
        $response->assertStatus(ResponseCode::HTTP_LOCKED);
    }

    public function testWorkerEnterWithRfidOnDeviceKeyShouldAllow(){
        [$worker, $lock] = self::InitRule('allow', true,true);

        $response = $this->put(route('access.enter', [$lock->id]), ['worker_id' => $worker->id]);
        $response->assertStatus(ResponseCode::HTTP_ACCEPTED);
    }

    public function testWorkerEnterWithRfidOnDeviceKeyShouldForbid(){
        [$worker, $lock] = self::InitRule('forbid', true, true);

        $response = $this->put(route('access.enter', [$lock->id]), ['worker_id' => $worker->id]);
        $response->assertStatus(ResponseCode::HTTP_LOCKED);
    }
}
