<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-200">
                {{ session('error') }}
            </div>
        @endif

        <nav class="text-sm text-zinc-500 dark:text-zinc-400">
            <a href="{{ route('dashboard') }}" class="font-medium text-red-700 hover:underline dark:text-red-400">Home</a>
            <span class="mx-1">/</span>
            <a href="{{ route('behandelingen.producten', $behandelingId) }}" class="font-medium text-red-700 hover:underline dark:text-red-400">Behandelingen</a>
            <span class="mx-1">/</span>
            <span class="text-zinc-400 dark:text-zinc-500">Wijzigen</span>
        </nav>

        <h1 class="text-2xl font-semibold tracking-tight">
            <span class="text-red-700 dark:text-red-400">Product wijzigen</span>
            <span class="text-zinc-500 dark:text-zinc-400">{{ $product->Naam }}</span>
        </h1>

        <form method="POST" action="{{ route('behandelingen.producten.update', [$behandelingId, $product->Id]) }}" class="max-w-4xl rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Product</label>
                    <input type="text" value="{{ $product->Naam }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Merk</label>
                    <input type="text" value="{{ $product->Merk }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Omschrijving</label>
                    <input type="text" value="{{ $product->Omschrijving }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">EAN-code</label>
                    <input type="text" value="{{ $product->EANcode }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Houdbaarheidsdatum</label>
                    <input type="text" value="{{ \Carbon\Carbon::parse($product->Houdbaarheidsdatum)->format('d-m-Y') }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Aantal op voorraad</label>
                    <input type="text" value="{{ $product->AantalOpVoorraad }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Inkoopprijs</label>
                    <input type="text" value="EUR {{ number_format($product->InkoopPrijs, 2, ',', '.') }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Leverancier</label>
                    <input type="text" value="{{ $product->LeverancierNaam }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Huidige verkoopprijs</label>
                    <input type="text" value="EUR {{ number_format($product->VerkoopPrijs, 2, ',', '.') }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Plaats leverancier</label>
                    <input type="text" value="{{ $product->LeverancierPlaats }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label for="nieuwe_verkoopprijs" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Nieuwe verkoopprijs <span class="text-rose-600">*</span>
                    </label>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        id="nieuwe_verkoopprijs"
                        name="nieuwe_verkoopprijs"
                        value="{{ old('nieuwe_verkoopprijs', number_format($product->VerkoopPrijs, 2, '.', '')) }}"
                        required
                        class="block w-full rounded-xl px-4 py-2.5 text-zinc-900 shadow-sm focus:ring-zinc-900 dark:bg-zinc-950 dark:text-zinc-100 {{ $errors->has('nieuwe_verkoopprijs') ? 'border-rose-500 focus:border-rose-500 ring-1 ring-rose-500' : 'border-zinc-300 focus:border-zinc-900 dark:border-zinc-700' }}"
                    >
                    @error('nieuwe_verkoopprijs')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Minimaal 30 procent boven de inkoopprijs.</p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Opmerking</label>
                    <input type="text" value="{{ $product->Opmerking ?? 'Geschikt voor dagelijks salongebruik' }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>
            </div>

            <p class="mt-5 text-xs text-zinc-500 dark:text-zinc-400">Velden met een <span class="text-rose-600">*</span> zijn verplicht.</p>

            <div class="mt-6 flex flex-wrap justify-end gap-3">
                <button type="submit" title="Nieuwe verkoopprijs opslaan" class="inline-flex items-center rounded-xl bg-red-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-800">
                    Opslaan
                </button>
                <a href="{{ route('behandelingen.producten.show', [$behandelingId, $product->Id]) }}" title="Terug naar productdetail" class="inline-flex items-center rounded-xl bg-zinc-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-600">
                    Terug
                </a>
            </div>
        </form>
    </div>
</x-layouts::app>
