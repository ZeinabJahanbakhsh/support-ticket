<?php

namespace Database\Factories;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoleUser>
 */
class RoleUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => Role::where('code', '<>', RoleEnum::admin)->get()->random(1)->value('id'),
            'user_id' => User::where('email', '<>', 'admin@admin.com')->get()->random(1)->value('id'),
        ];
    }
}
