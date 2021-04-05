<?php

namespace App\Http\Controllers;

use App\Http\Requests\LockGroupRequest;
use App\Http\Requests\LockGroupUpdateRequest;
use App\Http\Resources\LockGroupResource;
use App\Models\LockGroup;
use App\Utils\Bouncer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class LockGroupController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return LockGroupResource::collection(LockGroup::all());
    }

    public function store(LockGroupRequest $request)
    {
        $lockgroup = LockGroup::create($request->validated());
        return response(LockGroupResource::make($lockgroup), ResponseCode::HTTP_CREATED);
    }

    public function show(LockGroup $lockgroup): LockGroupResource
    {
        return LockGroupResource::make($lockgroup);
    }

    public function update(LockGroupUpdateRequest $request, LockGroup $lockgroup): JsonResponse
    {
        $lockgroup->update($request->validated());
        $lockgroup->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    public function destroy(LockGroup $lockgroup): JsonResponse
    {
        return Bouncer::TryDelete(LockGroup::class, $lockgroup);
    }
}
