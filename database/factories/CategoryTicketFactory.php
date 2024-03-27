<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CategoryTicket;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<CategoryTicket>
 */
class CategoryTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::all()->random(1)->value('id'),
            'ticket_id'   => Ticket::all()->random(1)->value('id'),
        ];
    }
}
