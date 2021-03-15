<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkerRequest;
use App\Http\Requests\WorkerUpdateRequest;
use App\Http\Resources\WorkerResource;
use App\Models\Worker;
use App\Utils\Bouncer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class WorkerController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return WorkerResource::collection(Worker::all());
    }

    public function store(WorkerRequest $request)
    {
        $worker = Worker::create($request->validated());
        return response(WorkerResource::make($worker), ResponseCode::HTTP_CREATED);
    }

    public function show(Worker $worker): WorkerResource
    {
        return WorkerResource::make($worker);
    }

    public function update(WorkerUpdateRequest $request, Worker $worker): JsonResponse
    {
        $worker->update($request->validated());
        $worker->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    public function destroy(Worker $worker): JsonResponse
    {
        return Bouncer::TryDelete(Worker::class, $worker);
    }
}
