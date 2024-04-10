<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $users = User::with([
            'role'
        ])->get();
        return UserResource::collection($users)
                           ->additional([
                               'count' => $users->count()
                           ]);

    }


    public function store(StoreUserRequest $request): UserResource
    {
        $request->validated();

        $user = User::forceCreate([
            'name'     => $request->string('name'),
            'email'    => $request->string('email'),
            'password' => $request->string('password'),
            'role_id'  => $request->integer('role_id')
                ? $request->integer('role_id')
                : Role::whereCode(RoleEnum::default)->value('id'),
        ]);

        return new UserResource($user);
    }


    public function show(User $user): UserResource
    {
        return new UserResource($user->load(['role']));
    }


    public function update(User $user, UpdateUserRequest $request): JsonResponse
    {
        $request->validated();

        $user->forceFill([
            'name'     => $request->string('name'),
            'email'    => $request->string('email'),
            'password' => $request->string('password'),
            'role_id'  => $request->input('role_id')
        ])->save();

        return response()->json([
            'message' => __('messages.update_success'),
            'data'    => $user
        ]);
    }


    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => __('messages.delete_success'),
        ]);
    }


}
