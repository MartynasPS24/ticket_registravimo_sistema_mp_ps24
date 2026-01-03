<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use App\Notifications\TicketCommentAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        // owner/admin/support gali matyti ticket
        $this->authorize('view', $ticket);

        // komentuoti gali tik admin arba support
        abort_unless(Auth::user()->isAdmin() || Auth::user()->isSupport(), 403);

        $validated = $request->validate([
            'body' => ['required', 'string'],
        ]);

        $comment = TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        // siusti pranesima ticket savininkui (jei komentuoja ne jis pats)
        $owner = $ticket->user;
        if ($owner && $owner->id !== Auth::id()) {
            $owner->notify(new TicketCommentAdded($ticket, $comment));
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Komentaras pridėtas.');
    }
}
