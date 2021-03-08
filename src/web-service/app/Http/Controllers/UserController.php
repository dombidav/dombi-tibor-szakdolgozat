<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        if($request->has('password') && $user !== Auth::user()) {
            return response()->json(['message' => 'You can not change the password of another user'])->setStatusCode(ResponseCode::HTTP_FORBIDDEN);
        }
        $user->update($request->validated());
        $user->save();
        return response()->json('', ResponseCode::HTTP_NO_CONTENT);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return UserResource
     * @throws Exception
     * @noinspection PhpUnusedParameterInspection
     */
    public function destroy(UserRequest $request, User $user)
    {
        $old = UserResource::make($user);
        $user->delete();
        return $old;
    }
}
