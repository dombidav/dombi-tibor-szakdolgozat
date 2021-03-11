<?php

namespace Http\Controllers;

use App\Http\Resources\WorkerResource;
use App\Models\User;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class WorkerControllerTest extends TestCase
{
    public function testWorkerIndex(){
        $this->assertModel('worker.index', WorkerResource::make(Worker::first()), [], Worker::count());
    }

    public function testWorkerShow(){
        $this->assertModel('worker.show', WorkerResource::make(Worker::first()), ['worker' => Worker::first()->id]);
    }

    public function testWorkerCreate(){
        $requestModel = [
            'name' => 'Test Worker',
            'born' => now(),
            'telephone' => $this->faker->phoneNumber
        ];

        $this->assertPermissionCanCreate('admin', 'worker', $requestModel, $requestModel);
    }

    public function testWorkerUpdate(){
        $this->assertPermissionCanUpdate('admin', 'worker', ['name' => 'Updated Worker'], Worker::latestOne());
    }

    public function testWorkerDelete(){
        $this->assertPermissionCanDelete('admin', 'worker', Worker::first());
    }
}
