<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ticket sąrašas
            </h2>

            <a href="{{ route('tickets.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white rounded">
                Naujas ticket
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-300 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <table class="w-full text-left">
                        <thead>
                        <tr class="border-b">
                            <th class="py-2">ID</th>
                            <th class="py-2">Pavadinimas</th>
                            <th class="py-2">Kategorija</th>
                            <th class="py-2">Statusas</th>
                            <th class="py-2">Veiksmai</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            <tr class="border-b">
                                <td class="py-2">{{ $ticket->id }}</td>
                                <td class="py-2">
                                    <a class="text-indigo-600 underline" href="{{ route('tickets.show', $ticket) }}">
                                        {{ $ticket->title }}
                                    </a>
                                </td>
                                <td class="py-2">{{ $ticket->category?->name }}</td>
                                <td class="py-2">{{ $ticket->status }}</td>
                                <td class="py-2">
                                    <a class="text-blue-600 underline mr-2" href="{{ route('tickets.edit', $ticket) }}">Redaguoti</a>

                                    <form class="inline" method="POST" action="{{ route('tickets.destroy', $ticket) }}"
                                          onsubmit="return confirm('Tikrai ištrinti?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 underline" type="submit">Trinti</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $tickets->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
