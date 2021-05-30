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
    /**
     * Get all @Team
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return TeamResource::collection(Team::all());
    }

    /**
     * Store a @Team
     * @param TeamRequest $request
     * @return ResponseFactory|Response
     */
    public function store(TeamRequest $request): ResponseFactory|Response
    {
        $team = Team::create($request->validated());
        return response(TeamResource::make($team), ResponseCode::HTTP_CREATED);
    }

    /**
     * Obtain a specific @Team
     * @param Team $team
     * @return TeamResource
     */
    public function show(Team $team): TeamResource
    {
        return TeamResource::make($team);
    }

    /**
     * Update a specific @Team
     * @param TeamUpdateRequest $request
     * @param Team $team
     * @return JsonResponse
     */
    public function update(TeamUpdateRequest $request, Team $team): JsonResponse
    {
        $team->update($request->validated());
        $team->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    /**
     * Remove a specific @Team
     * @param Team $team
     * @return JsonResponse
     */
    public function destroy(Team $team): JsonResponse
    {
        return Bouncer::TryDelete(Team::class, $team);
    }

    /**
     * Add a single @Worker to a @Team
     * @param WorkerTeamAttachRequest $request
     * @return JsonResponse
     */
    public function attach(WorkerTeamAttachRequest $request): JsonResponse{
        $validated = $request->validated();

        try{
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            Worker::find($validated['worker_id'])->teams()->attach($validated['team_id']);
        }catch (\Exception $e){
            return response()->json(['error' => $e])->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }
        return response()->json()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }

    /**
     * Remove a single @Worker from a @Team
     * @param WorkerTeamAttachRequest $request
     * @return JsonResponse|object
     */
    public function detach(WorkerTeamAttachRequest $request){
        $validated = $request->validated();

        try{
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            Worker::find($validated['worker_id'])->teams()->detach($validated['team_id']);
        }catch (\Exception $e){
            return response()->json(['error' => $e])->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }
        return response()->json()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }
}
