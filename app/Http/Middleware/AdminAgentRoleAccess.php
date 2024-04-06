<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function App\Helpers\adminRole;
use function App\Helpers\agentRole;

class AdminAgentRoleAccess
{

    public function handle(Request $request, Closure $next): Response
    {
        if (agentRole($request->user()) || adminRole($request->user())) {
            return $next($request);
        }

        return response()->json([
            'message' => __('messages.login_failed'),
        ]);

        /*$userRole = $request->user()->roles->toArray();

        if (
            $userRole[0]['code'] == RoleEnum::agent->value
            ||
            $userRole[0]['code'] == RoleEnum::admin->value
        ) {
            return $next($request);
        }

        return response()->json([
            'message' => __('messages.login_failed'),
        ]);*/

    }

}
