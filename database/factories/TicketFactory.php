<?php

namespace Database\Factories;

use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'       => fake()->title(),
            'description' => fake()->text(1500),
            'attachment'  => fake()->filePath(),
            'priority_id' => Priority::all()->random(1)->value('id'),
            'user_id'     => User::all()->random(1)->value('id'),
            'status_id'   => Status::all()->random(1)->value('id'),
        ];
    }
}
