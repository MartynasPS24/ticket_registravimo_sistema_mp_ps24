<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{

    // Kas gali matyti ticket

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $user->isSupport()
            || $ticket->user_id === $user->id;
    }


    // kurti

    public function create(User $user): bool
    {
        return true; // visi prisijungę
    }


    // redaguoti

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $ticket->user_id === $user->id;
    }


    // trinti

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $ticket->user_id === $user->id;
    }
}
