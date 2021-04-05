<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Http\Requests\WorkerTeamAttachRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Models\Worker;
use App\Utils\Bouncer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class TeamController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return TeamResource::collection(Team::all());
    }

    public function store(TeamRequest $request)
    {
        $group = Team::create($request->validated());
        return response(TeamResource::make($group), ResponseCode::HTTP_CREATED);
    }

    public function show(Team $group): TeamResource
    {
        return TeamResource::make($group);
    }

    public function update(TeamUpdateRequest $request, Team $group): JsonResponse
    {
        $group->update($request->validated());
        $group->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    public function destroy(Team $group): JsonResponse
    {
        return Bouncer::TryDelete(Team::class, $group);
    }

    public function attach(WorkerTeamAttachRequest $request): JsonResponse{
        $validated = $request->validated();

        try{
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            Worker::find($validated['worker_id'])->teams()->attach($validated['group_id']);
        }catch (\Exception $e){
            return response()->json(['error' => $e])->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }
        return response()->json()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }

    public function detach(WorkerTeamAttachRequest $request){
        $validated = $request->validated();

        try{
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            Worker::find($validated['worker_id'])->teams()->detach($validated['group_id']);
        }catch (\Exception $e){
            return response()->json(['error' => $e])->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }
        return response()->json()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }
}
