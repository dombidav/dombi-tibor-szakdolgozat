<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\BouncerFacade;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class UserController extends Controller
{

    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(UserRequest $request)
    {
        $validated = $request->except('password_confirmation');
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        return response(UserResource::make($user))->setStatusCode(ResponseCode::HTTP_CREATED);
    }

    public function show(User $user)
    {
        return UserResource::make($user);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse|object
     */
    public function update(UserRequest $request, User $user)
    {
        if($request->has('password') && ($user->id !== Auth::user()->id)) {
            return response()->json(['message' => 'You can not change the password of another user'], ResponseCode::HTTP_FORBIDDEN);
        }
        $user->update($request->validated());
        $user->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        if(!BouncerFacade::can('manage', User::class)) {
            return response()->json(['message' => 'You can not delete any user'], ResponseCode::HTTP_FORBIDDEN);
        }
        if($user->id === Auth::user()->id) {
            return response()->json(['message' => 'You can not delete your own account'], ResponseCode::HTTP_FORBIDDEN);
        }
        $user->delete();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }
}
