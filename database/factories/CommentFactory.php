<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'     => $this->faker->title,
            'text'      => $this->faker->text(1000),
            'ticket_id' => Ticket::all()->random(1)->value('id'),
            'user_id'   => User::where('id', '<>', 1)->get()->random(1)->value('id')
        ];
    }
}
