<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use function App\Helpers\adminRole;
use function App\Helpers\agentRole;


class TicketPolicy
{

    // Admin, Agent, Default
    public function viewAny(User $user): bool
    {
        return adminRole($user);
    }


    // Admin, Agent, Default
    public function view(User $user, Ticket $ticket): bool
    {
        if (adminRole($user) || $ticket->user_id == $user->id) {
            return true;
        }
        return false;
    }


    // Admin, Agent
    public function update(User $user, Ticket $ticket): bool
    {
        if (adminRole($user) || ($ticket->user_id == $user->id && agentRole($user))) {
            return true;
        }
        return false;
    }


}
