<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function App\Helpers\adminRole;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {

        if (adminRole($request->user())){
            return $next($request);
        }

        return response()->json([
            'message' => __('messages.login_failed'),
        ]);

       /* $userRole = $request->user()->roles->toArray();

        if ($userRole[0]['code'] != RoleEnum::admin->value) {
            return response()->json([
                'message' => __('messages.login_failed'),
            ]);
        }
        return $next($request);*/
    }

}
