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

                    <div class="pt-4">
                        <a class="text-blue-600 underline mr-3" href="{{ route('tickets.edit', $ticket) }}">Redaguoti</a>
                        <form class="inline" method="POST" action="{{ route('tickets.destroy', $ticket) }}"
                              onsubmit="return confirm('Tikrai ištrinti?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 underline" type="submit">Trinti</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
