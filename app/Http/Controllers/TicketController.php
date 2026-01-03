<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;


class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Ticket::with(['category', 'user'])->latest();

        // admin/support mato visus, user savo
        if (!($user->isAdmin() || $user->isSupport())) {
            $query->where('user_id', $user->id);
        }

        $tickets = $query->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'new',
        ]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket sukurtas.');
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load(['category', 'user', 'comments.user']);

        return view('tickets.show', compact('ticket'));
    }



    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $categories = Category::orderBy('name')->get();

        return view('tickets.edit', compact('ticket', 'categories'));
    }


    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket atnaujintas.');
    }


    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket ištrintas.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        // statusa keicia tik admin/support
        abort_unless(auth()->user()->isAdmin() || auth()->user()->isSupport(), 403);

        $validated = $request->validate([
            'status' => ['required', 'in:new,in_progress,done'],
        ]);

        $old = $ticket->status;
        $new = $validated['status'];

        if ($old !== $new) {
            $ticket->update(['status' => $new]);

            // email ticket savininkui
            $owner = $ticket->user;
            if ($owner) {
                $owner->notify(new \App\Notifications\TicketStatusChanged($ticket, $old, $new));
            }
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Statusas atnaujintas.');
    }

    public function activeTicketsPdf()
    {
        // tik admin/support
        abort_unless(auth()->user()->isAdmin() || auth()->user()->isSupport(), 403);


        $tickets = Ticket::with(['category', 'user'])
            ->where('status', '!=', 'done')
            ->latest()
            ->get();

        $generatedAt = now()->format('Y-m-d H:i');

        $pdf = Pdf::loadView('reports.active_tickets_pdf', [
            'tickets' => $tickets,
            'generatedAt' => $generatedAt,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('aktyvus_ticketai.pdf');
    }


}
