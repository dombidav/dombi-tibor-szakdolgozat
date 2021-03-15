<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkerRequest;
use App\Http\Requests\WorkerUpdateRequest;
use App\Http\Resources\WorkerResource;
use App\Models\Worker;
use Exception;
use Silber\Bouncer\BouncerFacade;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class WorkerController extends Controller
{
    public function index()
    {
        return WorkerResource::collection(Worker::all());
    }

    public function store(WorkerRequest $request)
    {
        $worker = Worker::create($request->validated());
        return response(WorkerResource::make($worker), ResponseCode::HTTP_CREATED);
    }

    public function show(Worker $worker)
    {
        return WorkerResource::make($worker);
    }

    public function update(WorkerUpdateRequest $request, Worker $worker)
    {
        $worker->update($request->validated());
        $worker->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    public function destroy(Worker $worker)
    {
        if(!BouncerFacade::can('manage', Worker::class)){
            return response()->json(['message' => 'You can not delete any workers'], ResponseCode::HTTP_FORBIDDEN);
        }
        try {
            $worker->delete();
        } catch (Exception $e) {
            response()->json($e, 500);
        }
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }
}
