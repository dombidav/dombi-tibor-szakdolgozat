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
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class AccessRuleController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return AccessRuleResource::collection(AccessRule::all());
    }

    public function store(AccessRuleRequest $request)
    {
        $access_rule = AccessRule::create($request->validated());
        return response(AccessRuleResource::make($access_rule), ResponseCode::HTTP_CREATED);
    }

    public function show(AccessRule $access_rule): AccessRuleResource
    {
        return AccessRuleResource::make($access_rule);
    }

    public function update(AccessRuleUpdateRequest $request, AccessRule $access_rule): JsonResponse
    {
        $access_rule->update($request->validated());
        $access_rule->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    public function destroy(AccessRule $access_rule): JsonResponse
    {
        return Bouncer::TryDelete(AccessRule::class, $access_rule);
    }

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
