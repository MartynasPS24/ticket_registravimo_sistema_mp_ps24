<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Naujas ticket
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-100 border border-red-300 rounded">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tickets.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block mb-1">Pavadinimas</label>
                            <input class="w-full border rounded p-2" name="title" value="{{ old('title') }}" required maxlength="150">
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Kategorija</label>
                            <select class="w-full border rounded p-2" name="category_id" required>
                                <option value="">-- pasirinkti --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">Aprašymas</label>
                            <textarea class="w-full border rounded p-2" name="description" rows="6" required>{{ old('description') }}</textarea>
                        </div>

                    <div class="mt-4 flex gap-3">
                        <x-primary-button type="submit">
                            Sukurti
                        </x-primary-button>

                        <a class="px-4 py-2 bg-gray-200 rounded" href="{{ route('tickets.index') }}">
                            Atgal
                        </a>
                    </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
