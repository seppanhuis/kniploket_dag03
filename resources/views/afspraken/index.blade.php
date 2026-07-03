<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl bg-zinc-100 p-4 dark:bg-zinc-950 sm:p-6 lg:p-8">

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <nav class="text-sm">
            <a href="{{ route('dashboard') }}" wire:navigate class="font-medium text-[#C8102E] hover:underline dark:text-red-300">Home</a>
            <span class="text-zinc-400"> / </span>
            <span class="text-zinc-500 dark:text-zinc-400">Afspraken</span>
        </nav>

        <h1 class="text-2xl font-bold text-[#C8102E] dark:text-red-300">Overzicht afspraken</h1>

        <form method="GET" action="{{ route('afspraken.index') }}" class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-end sm:justify-end">
                <div class="w-full sm:w-64">
                    <label for="status" class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Status selecteren</label>
                    <select id="status" name="status" class="block w-full rounded-xl border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                        <option value="" @selected($geselecteerdeStatus === '')>Alle statussen</option>
                        @foreach ($statussen as $status)
                            <option value="{{ $status }}" @selected($geselecteerdeStatus === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" title="Filter toepassen" class="inline-flex items-center rounded-lg bg-[#C8102E] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#a80d26]">
                        Maak selectie
                    </button>
                    <a href="{{ route('afspraken.index') }}" wire:navigate title="Filter resetten" class="inline-flex items-center rounded-lg bg-zinc-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-600">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex flex-col items-center gap-3 border-b border-zinc-200 px-4 py-3 dark:border-zinc-800">
                <p class="w-full text-sm text-zinc-500 dark:text-zinc-400">Gevonden afspraken - {{ $afspraken->total() }} afspraak(en)</p>

                @if ($afspraken->lastPage() > 1)
                    <div class="flex items-center justify-center gap-1">
                        <a href="{{ $afspraken->previousPageUrl() ?? '#' }}" wire:navigate title="Vorige pagina"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-300 text-zinc-500 hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-800">&lsaquo;</a>
                        @for ($p = 1; $p <= $afspraken->lastPage(); $p++)
                            <a href="{{ $afspraken->url($p) }}" wire:navigate title="Ga naar pagina {{ $p }}"
                                class="flex h-8 w-8 items-center justify-center rounded-lg text-sm font-medium {{ $p === $afspraken->currentPage() ? 'bg-[#C8102E] text-white' : 'border border-zinc-300 text-zinc-600 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                                {{ $p }}
                            </a>
                        @endfor
                        <a href="{{ $afspraken->nextPageUrl() ?? '#' }}" wire:navigate title="Volgende pagina"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-300 text-zinc-500 hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-800">&rsaquo;</a>
                    </div>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-[#C8102E] text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Klant</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Medewerker</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Behandeling</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Datum</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Starttijd</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Duur</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Eindtijd</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold">Actie</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($afspraken as $afspraak)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $afspraak->KlantNaam }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $afspraak->MedewerkerNaam }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $afspraak->BehandelingNaam }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ \Illuminate\Support\Carbon::parse($afspraak->Datum)->format('d-m-Y') }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ \Illuminate\Support\Carbon::parse($afspraak->Starttijd)->format('H:i') }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $afspraak->Duurminuten }} min</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ \Illuminate\Support\Carbon::parse($afspraak->Eindtijd)->format('H:i') }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $afspraak->Afspraakstatus }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('afspraken.show', $afspraak->Id) }}" wire:navigate title="Bekijk afspraakdetails van {{ $afspraak->KlantNaam }}"
                                        class="inline-flex items-center rounded-lg border border-blue-600 bg-transparent px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-50 dark:hover:bg-blue-950/40">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    Er zijn geen afspraken bekend die de geselecteerde status hebben
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
