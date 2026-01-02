<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ticket #{{ $ticket->id }}
            </h2>

            <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-200 rounded">
                Atgal į sąrašą
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-300 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-3">
                    <div><b>Pavadinimas:</b> {{ $ticket->title }}</div>
                    <div><b>Kategorija:</b> {{ $ticket->category?->name }}</div>
                    <div><b>Statusas:</b> {{ $ticket->status }}</div>
                    <div><b>Savininkas:</b> {{ $ticket->user?->name }} ({{ $ticket->user?->email }})</div>

                    <div>
                        <b>Aprašymas:</b>
                        <div class="mt-1 whitespace-pre-line">{{ $ticket->description }}</div>
                    </div>

                    <div class="pt-6 border-t">
                        <h3 class="font-semibold text-lg mb-3">Komentarai</h3>

                        @if($ticket->comments->count() === 0)
                            <div class="text-gray-600">Komentarų dar nėra.</div>
                        @else
                            <div class="space-y-3">
                                @foreach($ticket->comments as $comment)
                                    <div class="p-3 border rounded">
                                        <div class="text-sm text-gray-600">
                                            <b>{{ $comment->user?->name }}</b>
                                            ({{ $comment->created_at->format('Y-m-d H:i') }})
                                        </div>
                                        <div class="mt-1 whitespace-pre-line">{{ $comment->body }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if(auth()->user()->isAdmin() || auth()->user()->isSupport())
                        <div class="pt-4">
                            <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}">
                                @csrf

                                <label class="block mb-1 font-semibold">Pridėti komentarą</label>

                                <textarea class="w-full border rounded p-2 mb-3"
                                        name="body"
                                        rows="4"
                                        required></textarea>

                                <x-primary-button type="submit">
                                    Siųsti
                                </x-primary-button>
                            </form>
                        </div>
                    @endif



                    <div class="pt-4">
                        @can('update', $ticket)
                            <a class="text-blue-600 underline mr-3"
                            href="{{ route('tickets.edit', $ticket) }}">
                                Redaguoti
                            </a>
                        @endcan

                        @can('delete', $ticket)
                            <form class="inline" method="POST"
                                action="{{ route('tickets.destroy', $ticket) }}"
                                onsubmit="return confirm('Tikrai ištrinti?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 underline">Trinti</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
