<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Http\Requests\WorkerGroupAttachRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\Worker;
use App\Utils\Bouncer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class GroupController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return GroupResource::collection(Group::all());
    }

    public function store(GroupRequest $request)
    {
        $group = Group::create($request->validated());
        return response(GroupResource::make($group), ResponseCode::HTTP_CREATED);
    }

    public function show(Group $group): GroupResource
    {
        return GroupResource::make($group);
    }

    public function update(GroupUpdateRequest $request, Group $group): JsonResponse
    {
        $group->update($request->validated());
        $group->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    public function destroy(Group $group): JsonResponse
    {
        return Bouncer::TryDelete(Group::class, $group);
    }

    public function attach(WorkerGroupAttachRequest $request): JsonResponse{
        $validated = $request->validated();

        try{
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            Worker::find($validated['worker_id'])->groups()->attach($validated['group_id']);
        }catch (\Exception $e){
            return response()->json(['error' => $e])->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }
        return response()->json()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }

    public function detach(WorkerGroupAttachRequest $request){
        $validated = $request->validated();

        try{
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            Worker::find($validated['worker_id'])->groups()->detach($validated['group_id']);
        }catch (\Exception $e){
            return response()->json(['error' => $e])->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }
        return response()->json()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }
}
