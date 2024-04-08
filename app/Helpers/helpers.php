<?php

namespace App\Helpers;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;


if (!function_exists('adminRole')) {
    function adminRole($user): bool
    {
        return $user->role_id == Role::whereCode(RoleEnum::admin)->value('id');
    }
}


if (!function_exists('agentRole')) {
    function agentRole($user): bool
    {
        return $user->role_id == Role::whereCode(RoleEnum::agent)->value('id');
    }
}


if (!function_exists('defaultRole')) {
    function defaultRole($user): bool
    {
        return $user->role_id == Role::whereCode(RoleEnum::default)->value('id');
    }
}



