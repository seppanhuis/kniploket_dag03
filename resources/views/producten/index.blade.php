<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-200">
                {{ session('error') }}
            </div>
        @endif

        <div>
            <nav class="text-sm">
                <a href="{{ route('dashboard') }}" title="Naar het dashboard" class="font-medium text-red-700 hover:underline">Home</a>
                <span class="text-zinc-400"> / </span>
                <span class="text-zinc-500 dark:text-zinc-400">Producten</span>
            </nav>
            <h1 class="mt-2 text-2xl font-bold text-red-700">Overzicht producten</h1>
        </div>

        {{-- Filterblok --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <form method="GET" action="{{ route('producten.index') }}" class="flex flex-col items-end gap-3 sm:flex-row sm:justify-end">
                <div class="w-full sm:w-64">
                    <label for="categorie_id" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Categorie selecteren
                    </label>
                    <select
                        id="categorie_id"
                        name="categorie_id"
                        title="Selecteer een categorie om op te filteren"
                        class="block w-full rounded-lg border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100"
                    >
                        <option value="" {{ is_null($geselecteerdeCategorieId) ? 'selected' : '' }}>Alle categorieën</option>
                        @foreach ($categorieen as $categorie)
                            <option value="{{ $categorie->Id }}" {{ (int) $geselecteerdeCategorieId === (int) $categorie->Id ? 'selected' : '' }}>
                                {{ $categorie->Naam }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit" title="Filter toepassen op geselecteerde categorie" class="inline-flex items-center rounded-lg bg-red-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-800">
                        Maak selectie
                    </button>
                    <a href="{{ route('producten.index') }}" title="Filter wissen en alle producten tonen" class="inline-flex items-center rounded-lg bg-zinc-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-600">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Resultatenblok --}}
        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="relative flex flex-col items-center gap-3 border-b border-zinc-200 p-4 dark:border-zinc-800">
                <p class="self-start text-sm text-zinc-500 dark:text-zinc-400 sm:absolute sm:left-4 sm:top-1/2 sm:-translate-y-1/2">
                    Gevonden producten - {{ $producten->total() }} product(en)
                </p>

                @if ($producten->lastPage() > 1)
                    <div class="flex items-center gap-2">
                        <a
                            href="{{ $producten->currentPage() > 1 ? $producten->url($producten->currentPage() - 1) : '#' }}"
                            title="Vorige pagina"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-300 text-zinc-500 dark:border-zinc-700 {{ $producten->currentPage() > 1 ? 'hover:bg-zinc-100 dark:hover:bg-zinc-800' : 'cursor-not-allowed opacity-50' }}"
                        >
                            &lsaquo;
                        </a>

                        @for ($i = 1; $i <= $producten->lastPage(); $i++)
                            <a
                                href="{{ $producten->url($i) }}"
                                title="Ga naar pagina {{ $i }}"
                                class="flex h-8 w-8 items-center justify-center rounded-lg text-sm font-medium {{ $i === $producten->currentPage() ? 'bg-red-700 text-white' : 'border border-zinc-300 text-red-700 hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-800' }}"
                            >
                                {{ $i }}
                            </a>
                        @endfor

                        <a
                            href="{{ $producten->currentPage() < $producten->lastPage() ? $producten->url($producten->currentPage() + 1) : '#' }}"
                            title="Volgende pagina"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-300 text-zinc-500 dark:border-zinc-700 {{ $producten->currentPage() < $producten->lastPage() ? 'hover:bg-zinc-100 dark:hover:bg-zinc-800' : 'cursor-not-allowed opacity-50' }}"
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
                            <th class="px-4 py-3 text-left text-sm font-semibold text-white">Product</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-white">Categorie</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-white">Merk</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-white">EAN-code</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-white">Verkoopprijs</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-white">Voorraad</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-white">Actie</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($producten as $product)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Naam }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $product->CategorieNaam }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $product->Merk }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $product->EANcode }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">EUR {{ number_format($product->VerkoopPrijs, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $product->AantalOpVoorraad }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('producten.show', $product->Id) }}" title="Bekijk details van {{ $product->Naam }}" class="inline-flex items-center rounded-lg border border-blue-500 px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-50 dark:hover:bg-blue-950/40">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    Er zijn geen producten bekend binnen de geselecteerde categorie
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
