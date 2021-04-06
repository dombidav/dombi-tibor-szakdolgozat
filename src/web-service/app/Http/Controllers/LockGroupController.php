<?php

namespace App\Http\Controllers;

use App\Http\Requests\LockGroupAttachRequest;
use App\Http\Requests\LockGroupRequest;
use App\Http\Requests\LockGroupUpdateRequest;
use App\Http\Resources\LockGroupResource;
use App\Models\Lock;
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

    public function show(LockGroup $lock_group): LockGroupResource
    {
        return LockGroupResource::make($lock_group);
    }

    public function update(LockGroupUpdateRequest $request, LockGroup $lock_group): JsonResponse
    {
        $lock_group->update($request->validated());
        $lock_group->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    public function destroy(LockGroup $lock_group): JsonResponse
    {
        return Bouncer::TryDelete(LockGroup::class, $lock_group);
    }

    public function attach(LockGroupAttachRequest $request): JsonResponse{
        $validated = $request->validated();
        try{
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            Lock::find($validated['lock_id'])->groups()->attach($validated['lock_group_id']);
        }catch (\Exception $e){
            return response()->json(['error' => $e])->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }
        return response()->json()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }

    public function detach(LockGroupAttachRequest $request): JsonResponse{
        $validated = $request->validated();
        try{
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            Lock::find($validated['lock_id'])->groups()->detach($validated['lock_group_id']);
        }catch (\Exception $e){
            return response()->json(['error' => $e])->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }
        return response()->json()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }


}
