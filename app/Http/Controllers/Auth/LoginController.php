<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(LoginUserRequest $request): JsonResponse
    {
        $request->validated();

        if (!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
               'message' => __('messages.operation_failed')
            ]);
        }

        return response()->json([
           'message' => __('messages.login_user_success'),
        ]);
    }


}
