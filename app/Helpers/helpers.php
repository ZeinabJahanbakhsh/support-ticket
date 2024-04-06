<?php

namespace App\Helpers;

use App\Enums\RoleEnum;
use App\Models\User;


if (!function_exists('adminRole')) {
    function adminRole($user): bool
    {
        $userRole = $user->roles->toArray();
        return $userRole[0]['code'] == RoleEnum::admin->value;
    }
}


if (!function_exists('agentRole')) {
    function agentRole($user): bool
    {
        $userRole = $user->roles->toArray();
        return $userRole[0]['code'] == RoleEnum::agent->value;
    }
}


if (!function_exists('defaultRole')) {
    function defaultRole($user): bool
    {
        $userRole = $user->roles->toArray();
        return $userRole[0]['code'] == RoleEnum::default->value;
    }
}


if (!function_exists('userRole')) {
    function userRole($user): array
    {
        return $user->roles->toArray();
    }
}



