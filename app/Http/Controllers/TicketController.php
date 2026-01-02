<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Ticket::with(['category', 'user'])->latest();

        // paprasta role logika: admin/support mato visus, user - tik savo
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

}
