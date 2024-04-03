<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllRolesAccess
{

    public function handle(Request $request, Closure $next): Response
    {
        $userRole = $request->user()->roles->toArray();

        if (
            $userRole[0]['code'] == RoleEnum::admin->value
            ||
            $userRole[0]['code'] == RoleEnum::agent->value
            ||
            $userRole[0]['code'] == RoleEnum::default->value
        ) {
            return $next($request);
        }

        return response()->json([
            'message' => __('messages.login_failed'),
        ]);

    }

}
