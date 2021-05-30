<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessRuleRequest;
use App\Http\Requests\AccessRuleUpdateRequest;
use App\Http\Requests\RuleAttachRequest;
use App\Http\Resources\AccessRuleResource;
use App\Models\AccessRule;
use App\Models\LockGroup;
use App\Models\Team;
use App\Utils\Bouncer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class AccessRuleController extends Controller
{
    /**
     * Get all Access Rules
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return AccessRuleResource::collection(AccessRule::all());
    }

    /**
     * Store an Access Rule
     * @param AccessRuleRequest $request
     * @return ResponseFactory|Response
     */
    public function store(AccessRuleRequest $request)
    {
        $access_rule = AccessRule::create($request->validated());
        return response(AccessRuleResource::make($access_rule), ResponseCode::HTTP_CREATED);
    }

    /**
     * Obtain an Access Rule
     * @param AccessRule $access_rule
     * @return AccessRuleResource
     */
    public function show(AccessRule $access_rule): AccessRuleResource
    {
        return AccessRuleResource::make($access_rule);
    }

    /**
     * Update a specific Access Rule
     * @param AccessRuleUpdateRequest $request
     * @param AccessRule $access_rule
     * @return JsonResponse
     */
    public function update(AccessRuleUpdateRequest $request, AccessRule $access_rule): JsonResponse
    {
        $access_rule->update($request->validated());
        $access_rule->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    /**
     * Remove a specific Access Rule
     * @param AccessRule $access_rule
     * @return JsonResponse
     */
    public function destroy(AccessRule $access_rule): JsonResponse
    {
        return Bouncer::TryDelete(AccessRule::class, $access_rule);
    }

    /**
     * Attaches a @Team, a @LockGroup or both to an @AccessRule, depending on request
     * @param RuleAttachRequest $request
     * @return JsonResponse|object
     */
    public function attach(RuleAttachRequest $request){
        $validated = $request->validated();

        try{
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            LockGroup::find($validated['lock_group_id'] ?? '')?->rules()?->attach($validated['access_rule_id']);
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            Team::find($validated['team_id'] ?? '')?->rules()?->attach($validated['access_rule_id']);
        }catch (\Exception $e){
            return response()->json(['error' => $e])->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }
        return response()->json()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }

    /**
     * Detaches a @Team, a @LockGroup or both from an @AccessRule, depending on request
     * @param RuleAttachRequest $request
     * @return JsonResponse|object
     */
    public function detach(RuleAttachRequest $request){
        $validated = $request->validated();

        try{
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            LockGroup::find($validated['lock_group_id'] ?? '')?->rules()?->detach($validated['access_rule_id']);
            /** @noinspection PhpPossiblePolymorphicInvocationInspection : The return of Find function is defined in APIResource trait */
            /** @noinspection NullPointerExceptionInspection : Safe navigation should handle null pointers, PhpStorm bug? */
            Team::find($validated['team_id'] ?? '')?->rules()?->detach($validated['access_rule_id']);
        }catch (\Exception $e){
            return response()->json(['error' => $e])->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }
        return response()->json()->setStatusCode(ResponseCode::HTTP_NO_CONTENT);
    }
}
