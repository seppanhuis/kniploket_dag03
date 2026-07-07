<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">

        <nav class="text-sm text-zinc-500 dark:text-zinc-400">
            <a href="{{ route('dashboard') }}" title="Naar het dashboard" class="font-medium text-red-700 hover:underline dark:text-red-400">Home</a>
            <span class="mx-1">/</span>
            <span class="text-zinc-400 dark:text-zinc-500">Medewerkers</span>
        </nav>

        <h1 class="text-2xl font-semibold tracking-tight text-red-700 dark:text-red-400">Overzicht medewerkers</h1>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <form method="GET" action="{{ route('medewerkers.index') }}" class="flex flex-col items-end gap-3 sm:flex-row sm:justify-end">
                <div class="w-full sm:w-64">
                    <label for="specialisatie" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Specialisatie</label>
                    <select id="specialisatie" name="specialisatie" title="Filter medewerkers op specialisatie" class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                        <option value="alle" @selected($filter === 'alle')>Alle specialisaties</option>
                        @foreach ($specialisaties as $specialisatie)
                            <option value="{{ $specialisatie }}" @selected($filter === $specialisatie)>{{ $specialisatie }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit" title="Filter toepassen op geselecteerde specialisatie" class="inline-flex items-center rounded-xl bg-red-700 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-800">
                        Toon medewerkers
                    </button>
                    <a href="{{ route('medewerkers.index') }}" title="Filter wissen en alle medewerkers tonen" class="inline-flex items-center rounded-xl bg-zinc-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-600">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="relative flex flex-col items-center gap-3 border-b border-zinc-200 p-4 dark:border-zinc-800">
                <p class="self-start text-sm text-zinc-500 dark:text-zinc-400 sm:absolute sm:left-4 sm:top-1/2 sm:-translate-y-1/2">
                    Gevonden medewerkers - {{ $medewerkers->total() }} medewerker(s)
                </p>

                @if ($medewerkers->lastPage() > 1)
                    <div class="flex items-center gap-2">
                        <a
                            href="{{ $medewerkers->currentPage() > 1 ? $medewerkers->url($medewerkers->currentPage() - 1) : '#' }}"
                            title="Vorige pagina"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-300 text-zinc-500 dark:border-zinc-700 {{ $medewerkers->currentPage() > 1 ? 'hover:bg-zinc-100 dark:hover:bg-zinc-800' : 'cursor-not-allowed opacity-50' }}"
                        >
                            &lsaquo;
                        </a>

                        @for ($i = 1; $i <= $medewerkers->lastPage(); $i++)
                            <a
                                href="{{ $medewerkers->url($i) }}"
                                title="Ga naar pagina {{ $i }}"
                                class="flex h-8 w-8 items-center justify-center rounded-lg text-sm font-medium {{ $i === $medewerkers->currentPage() ? 'bg-red-700 text-white' : 'border border-zinc-300 text-red-700 hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-800' }}"
                            >
                                {{ $i }}
                            </a>
                        @endfor

                        <a
                            href="{{ $medewerkers->currentPage() < $medewerkers->lastPage() ? $medewerkers->url($medewerkers->currentPage() + 1) : '#' }}"
                            title="Volgende pagina"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-300 text-zinc-500 dark:border-zinc-700 {{ $medewerkers->currentPage() < $medewerkers->lastPage() ? 'hover:bg-zinc-100 dark:hover:bg-zinc-800' : 'cursor-not-allowed opacity-50' }}"
                        >
                            &rsaquo;
                        </a>
                    </div>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-red-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Naam</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Specialisatie</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Adres</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Postcode</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Woonplaats</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Mobiel</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Contact e-mail</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-white">Actie</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($medewerkers as $medewerker)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->VolledigeNaam }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $medewerker->Specialisatie }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $medewerker->Adres }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $medewerker->Postcode }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $medewerker->Plaats }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $medewerker->Mobiel }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $medewerker->ContactEmail }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('medewerkers.show', $medewerker->Id) }}" title="Bekijk details van {{ $medewerker->VolledigeNaam }}" class="inline-flex items-center rounded-lg border border-blue-500 px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-50 dark:hover:bg-blue-950/40">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Er zijn geen medewerkers bekend met de geselecteerde specialisatie</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
