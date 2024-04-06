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
        /* return adminRole($user)
             ? Response::allow()
             : Response::denyAsNotFound();*/

        if (adminRole($user) || $ticket->user_id == $user->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        if (adminRole($user) || ($ticket->user_id == $user->id && agentRole($user))) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        //
    }


    public function adminAgentDefault(User $user, $ticket): bool
    {
        $this->adminRole($user);

        if ($userRole[0]['code'] == RoleEnum::agent->value && $ticket->user_id == $user->id) {
            return true;
        }

        if ($userRole[0]['code'] == RoleEnum::default->value && $ticket->user_id == $user->id) {
            return true;
        }

        return false;
    }


}
