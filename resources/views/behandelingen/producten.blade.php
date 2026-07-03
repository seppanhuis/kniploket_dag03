<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">

        <nav class="text-sm text-zinc-500 dark:text-zinc-400">
            <a href="{{ route('dashboard') }}" class="font-medium text-red-700 hover:underline dark:text-red-400">Home</a>
            <span class="mx-1">/</span>
            <a href="{{ route('behandelingen.index') }}" class="font-medium text-red-700 hover:underline dark:text-red-400">Behandelingen</a>
            <span class="mx-1">/</span>
            <span class="text-zinc-400 dark:text-zinc-500">Detail</span>
        </nav>

        <h1 class="text-2xl font-semibold tracking-tight">
            <span class="text-red-700 dark:text-red-400">Producten per behandeling</span>
            <span class="text-zinc-500 dark:text-zinc-400">{{ $behandeling->Naam }}</span>
        </h1>

        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                    <thead class="bg-red-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Product</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Merk</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Omschrijving</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">EAN-code</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Aantal op voorraad</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-white">Verkoopprijs</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-white">Actie</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse ($producten as $product)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Naam }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $product->Merk }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $product->Omschrijving }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $product->EANcode }}</td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-300">{{ $product->AantalOpVoorraad }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-zinc-900 dark:text-zinc-100">EUR {{ number_format($product->VerkoopPrijs, 2, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('behandelingen.producten.show', [$behandeling->Id, $product->Id]) }}" class="inline-flex items-center rounded-lg bg-red-700 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-red-800">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">Er zijn geen producten gekoppeld aan deze behandeling</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end border-t border-zinc-200 p-4 dark:border-zinc-800">
                <a href="{{ route('behandelingen.index') }}" class="inline-flex items-center rounded-lg border border-blue-500 px-4 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-50 dark:hover:bg-blue-950/40">
                    Terug
                </a>
            </div>
        </div>
    </div>
</x-layouts::app>
