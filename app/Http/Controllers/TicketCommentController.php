<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketCommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        // ticket peržiūra turi būti leidžiama (owner/admin/support)
        $this->authorize('view', $ticket);

        // komentaruoti gali tik admin arba support
        abort_unless(Auth::user()->isAdmin() || Auth::user()->isSupport(), 403);

        $validated = $request->validate([
            'body' => ['required', 'string'],
        ]);

        TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'body' => $validated['body'],
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Komentaras pridėtas.');
    }
}
