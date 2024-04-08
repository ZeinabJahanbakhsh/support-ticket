<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use DB;
use function PHPUnit\Framework\isEmpty;


class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $users = User::with([
            'roles'
        ])->get();
        return UserResource::collection($users)
                           ->additional([
                               'count' => $users->count()
                           ]);

    }


    public function show(User $user): UserResource
    {
        return new UserResource($user->load(['roles']));
    }


    public function update(User $user, UpdateUserRequest $request)
    {
        DB::transaction(function () use ($request, $user) {

            $user->forceFill([
                'name'     => $request->string('name'),
                'email'    => $request->string('email'),
                'password' => $request->string('password'),
            ])->save();

            if (isEmpty($request->input('role-ids'))) {
                $user->roles()->attach(Role::whereCode(RoleEnum::default)->value('id'));
            }
            $request->collect('role_ids')->each(function ($value) use ($user) {
                $user->roles()->sync($value);
            });

        });

        return response()->json([
            'message' => __('messages.update_success'),
            'data'    => $user
        ]);
    }



    public function destroy(User $user)
    {
        //
    }



}
