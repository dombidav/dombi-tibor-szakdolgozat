<?php

namespace Http\Controllers;

use App\Http\Resources\WorkerResource;
use App\Models\User;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class WorkerControllerTest extends TestCase
{
    public function testWorkerIndex(): void
    {
        $this->assertModel('worker.index', WorkerResource::make(Worker::first()), [], Worker::count());
    }

    public function testWorkerShow(): void
    {
        $this->assertModel('worker.show', WorkerResource::make(Worker::first()), ['worker' => Worker::first()->id]);
    }

    public function testWorkerCreate(): void
    {
        $this->withoutExceptionHandling();
        $requestModel = [
            'name' => 'Test Worker',
            'birthdate' => now()->toDateString(),
            'rfid' => Str::random(6),
            'telephone' => $this->faker->e164PhoneNumber
        ];

        $this->assertPermissionCanCreate('admin', 'worker', $requestModel, $requestModel);
    }

    public function testWorkerUpdate(): void
    {
        $this->assertPermissionCanUpdate('admin', 'worker', ['name' => 'Updated Worker'], Worker::latestOne());
    }

    public function testWorkerDelete(): void
    {
        $this->assertPermissionCanDelete('admin', 'worker', Worker::first());
    }
}
