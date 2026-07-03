<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-200">
                {{ session('error') }}
            </div>
        @endif

        <div>
            <nav class="text-sm">
                <a href="{{ route('dashboard') }}" title="Naar het dashboard" class="font-medium text-red-700 hover:underline">Home</a>
                <span class="text-zinc-400"> / </span>
                <a href="{{ route('producten.index') }}" title="Naar het productoverzicht" class="font-medium text-red-700 hover:underline">Producten</a>
                <span class="text-zinc-400"> / </span>
                <span class="text-zinc-500 dark:text-zinc-400">Wijzigen</span>
            </nav>
            <h1 class="mt-2 text-2xl font-bold">
                <span class="text-red-700">Product wijzigen</span>
                <span class="text-zinc-700 dark:text-zinc-200">{{ $product->Naam }}</span>
            </h1>
        </div>

        <form method="POST" action="{{ route('producten.update', $product->Id) }}" class="max-w-3xl rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Product</label>
                    <input type="text" value="{{ $product->Naam }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Merk</label>
                    <input type="text" value="{{ $product->Merk }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Omschrijving</label>
                    <input type="text" value="{{ $product->Omschrijving }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">EAN-code</label>
                    <input type="text" value="{{ $product->EANcode }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Inkoopprijs</label>
                    <input type="text" value="EUR {{ number_format($product->InkoopPrijs, 2, ',', '.') }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Aantal op voorraad</label>
                    <input type="text" value="{{ $product->AantalOpVoorraad }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Huidige verkoopprijs</label>
                    <input type="text" value="EUR {{ number_format($product->VerkoopPrijs, 2, ',', '.') }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Leverancier</label>
                    <input type="text" value="{{ $product->LeverancierNaam ?? '-' }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Houdbaarheidsdatum</label>
                    <input type="text" value="{{ \Illuminate\Support\Carbon::parse($product->Houdbaarheidsdatum)->format('d-m-Y') }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Plaats leverancier</label>
                    <input type="text" value="{{ $product->LeverancierPlaats ?? '-' }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label for="nieuwe_houdbaarheidsdatum" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Nieuwe houdbaarheidsdatum <span class="text-rose-600">*</span>
                    </label>
                    <input
                        type="date"
                        id="nieuwe_houdbaarheidsdatum"
                        name="nieuwe_houdbaarheidsdatum"
                        title="Vul de nieuwe houdbaarheidsdatum in (max. 7 dagen verlenging)"
                        value="{{ old('nieuwe_houdbaarheidsdatum', \Illuminate\Support\Carbon::parse($product->Houdbaarheidsdatum)->format('Y-m-d')) }}"
                        required
                        class="block w-full rounded-xl border px-4 py-2.5 text-zinc-900 shadow-sm focus:ring-zinc-900 dark:bg-zinc-950 dark:text-zinc-100 {{ $errors->has('nieuwe_houdbaarheidsdatum') ? 'border-rose-500 focus:border-rose-500' : 'border-zinc-300 focus:border-zinc-900 dark:border-zinc-700' }}"
                    >
                    @error('nieuwe_houdbaarheidsdatum')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs {{ $errors->has('nieuwe_houdbaarheidsdatum') ? 'text-rose-600' : 'text-zinc-500 dark:text-zinc-400' }}">
                        De houdbaarheidsdatum mag uiterlijk met 7 dagen worden verlengd.
                    </p>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Opmerking</label>
                    <input type="text" value="{{ $product->Opmerking }}" disabled
                        class="block w-full rounded-xl border border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>
            </div>

            <p class="mt-4 text-xs text-zinc-500 dark:text-zinc-400">
                Velden met een <span class="text-rose-600">*</span> zijn verplicht.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" title="Wijzigingen opslaan" class="inline-flex items-center rounded-xl bg-red-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-800">
                    Opslaan
                </button>
                <a href="{{ route('producten.show', $product->Id) }}" title="Terug naar productdetail zonder op te slaan" class="inline-flex items-center rounded-xl bg-zinc-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-600">
                    Terug
                </a>
            </div>
        </form>
    </div>
</x-layouts::app>
