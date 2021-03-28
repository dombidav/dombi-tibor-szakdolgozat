<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessRuleRequest;
use App\Http\Requests\AccessRuleUpdateRequest;
use App\Http\Resources\AccessRuleResource;
use App\Models\AccessRule;
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
        $accessrule = AccessRule::create($request->validated());
        return response(AccessRuleResource::make($accessrule), ResponseCode::HTTP_CREATED);
    }

    public function show(AccessRule $accessrule): AccessRuleResource
    {
        return AccessRuleResource::make($accessrule);
    }

    public function update(AccessRuleUpdateRequest $request, AccessRule $accessrule): JsonResponse
    {
        $accessrule->update($request->validated());
        $accessrule->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    public function destroy(AccessRule $accessrule): JsonResponse
    {
        return Bouncer::TryDelete(AccessRule::class, $accessrule);
    }
}
