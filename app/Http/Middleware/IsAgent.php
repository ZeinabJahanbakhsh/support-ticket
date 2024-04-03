<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAgent
{
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = $request->user()->roles->toArray();

        if ($userRole[0]['code'] != RoleEnum::agent->value) {
            return response()->json([
                'message' => __('messages.login_failed'),
            ]);
        }
        return $next($request);
    }

}
