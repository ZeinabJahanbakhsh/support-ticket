<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function App\Helpers\adminRole;
use function App\Helpers\agentRole;
use function App\Helpers\defaultRole;

class AllRolesAccess
{

    public function handle(Request $request, Closure $next): Response
    {
        if (adminRole($request->user()) || agentRole($request->user()) || defaultRole($request->user())) {
            return $next($request);
        }

        return response()->json([
            'message' => __('messages.login_failed'),
        ]);

    }

}
