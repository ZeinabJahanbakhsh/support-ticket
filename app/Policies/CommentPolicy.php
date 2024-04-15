<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{

    public function view(User $user, Comment $comment): bool
    {
        $ticket = \request()->route()->parameter('ticket');

        if ($ticket->assigned_to == null && $ticket->user_id == $user->id && $comment->ticket_id == $ticket->id) {
            return true;
        }

        if ($ticket->assigned_to != null && $ticket->assigned_to == $user->id && $comment->ticket_id == $ticket->id) {
            return true;
        }

        return false;
    }


}
