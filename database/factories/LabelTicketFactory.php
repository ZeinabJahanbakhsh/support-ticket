<?php

namespace Database\Factories;

use App\Models\Label;
use App\Models\LabelTicket;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LabelTicket>
 */
class LabelTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label_id'  => Label::all()->random(1)->value('id'),
            'ticket_id' => Ticket::all()->random(1)->value('id'),
        ];
    }

}
