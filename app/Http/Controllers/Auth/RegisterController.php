<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use DB;


class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $request->validated();

        DB::transaction(function () use ($request, &$user) {

            $user = User::forceCreate([
                'name'     => $request->string('name'),
                'email'    => $request->string('email'),
                'password' => $request->string('password'),
            ]);

            $user->roles()->attach([
                Role::whereCode(RoleEnum::default)->value('id')
            ]);

            $token = $user->createToken('register-user-token')->plainTextToken;
            $request->merge([
                'token' => $token,
            ]);
        });

        return new UserResource($user);
    }


}
