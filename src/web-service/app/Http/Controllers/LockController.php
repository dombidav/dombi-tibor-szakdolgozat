<?php

namespace App\Http\Controllers;

use App\Http\Requests\LockRequest;
use App\Http\Requests\LockUpdateRequest;
use App\Http\Resources\LockResource;
use App\Models\Lock;
use App\Utils\Bouncer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class LockController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return LockResource::collection(Lock::all());
    }

    public function store(LockRequest $request)
    {
        $lock = Lock::create($request->validated());
        return response(LockResource::make($lock), ResponseCode::HTTP_CREATED);
    }

    public function show(Lock $lock): LockResource
    {
        return LockResource::make($lock);
    }

    public function update(LockUpdateRequest $request, Lock $lock): JsonResponse
    {
        $lock->update($request->validated());
        $lock->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    public function destroy(Lock $lock): JsonResponse
    {
        return Bouncer::TryDelete(Lock::class, $lock);
    }
}
