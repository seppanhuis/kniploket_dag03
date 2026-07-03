<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">

        <nav class="text-sm text-zinc-500 dark:text-zinc-400">
            <a href="{{ route('dashboard') }}" class="font-medium text-red-700 hover:underline dark:text-red-400">Home</a>
            <span class="mx-1">/</span>
            <span class="text-zinc-400 dark:text-zinc-500">Behandelingen</span>
        </nav>

        <h1 class="text-2xl font-semibold tracking-tight text-red-700 dark:text-red-400">Overzicht behandelingen</h1>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <form method="GET" action="{{ route('behandelingen.index') }}" class="flex flex-col items-end gap-3 sm:flex-row sm:justify-end">
                <div class="w-full sm:w-64">
                    <label for="filter" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Behandeling selecteren</label>
                    <select id="filter" name="filter" class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                        <option value="alle" @selected($filter === 'alle')>Alle behandelingen</option>
                        @foreach ($soorten as $soort)
                            <option value="{{ $soort }}" @selected($filter === $soort)>{{ $soort }}</option>
                        @endforeach
                        <option value="overig" @selected($filter === 'overig')>Overig</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center rounded-xl bg-red-700 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-800">
                        Maak selectie
                    </button>
                    <a href="{{ route('behandelingen.index') }}" class="inline-flex items-center rounded-xl bg-zinc-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-600">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex flex-col gap-3 p-6 pb-0">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Gevonden behandelingen - {{ $behandelingen->total() }} behandeling(en)</p>

                @if ($behandelingen->hasPages())
                    <div class="flex justify-center">
                        {{ $behandelingen->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>

            <div class="overflow-x-auto p-6 pt-4">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-red-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Soort</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Omschrijving</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Duur</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Prijs</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Aantal producten</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-white">Actie</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($behandelingen as $behandeling)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $behandeling->Naam }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $behandeling->Omschrijving }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $behandeling->Duurminuten }} min</td>
                                <td class="px-4 py-3 text-sm font-medium text-zinc-900 dark:text-zinc-100">EUR {{ number_format($behandeling->Prijs, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $behandeling->AantalProducten }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('behandelingen.producten', $behandeling->Id) }}" class="inline-flex items-center rounded-lg border border-blue-500 px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-50 dark:hover:bg-blue-950/40">
                                        Producten
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Er zijn geen behandelingen bekend met deze naam</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
