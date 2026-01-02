<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Kas gali matyti ticket (show)
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $user->isSupport()
            || $ticket->user_id === $user->id;
    }

    /**
     * Kas gali kurti ticket
     */
    public function create(User $user): bool
    {
        return true; // visi prisijungę
    }

    /**
     * Kas gali redaguoti ticket
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $ticket->user_id === $user->id;
    }

    /**
     * Kas gali trinti ticket
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $ticket->user_id === $user->id;
    }
}
