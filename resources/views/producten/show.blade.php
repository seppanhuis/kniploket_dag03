<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">

        @if (session('success'))
            <div id="success-melding" class="max-w-3xl rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-3xl rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-200">
                {{ session('error') }}
            </div>
        @endif

        <div>
            <nav class="text-sm">
                <a href="{{ route('dashboard') }}" title="Naar het dashboard" class="font-medium text-red-700 hover:underline">Home</a>
                <span class="text-zinc-400"> / </span>
                <a href="{{ route('producten.index') }}" title="Naar het productoverzicht" class="font-medium text-red-700 hover:underline">Producten</a>
                <span class="text-zinc-400"> / </span>
                <span class="text-zinc-500 dark:text-zinc-400">Detail</span>
            </nav>
            <h1 class="mt-2 text-2xl font-bold">
                <span class="text-red-700">Productdetail</span>
                <span class="text-zinc-700 dark:text-zinc-200">{{ $product->Naam }}</span>
            </h1>
        </div>

        <div class="max-w-3xl rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <dl class="divide-y divide-zinc-200 dark:divide-zinc-800">
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Product</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Naam }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Merk</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Merk }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Omschrijving</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Omschrijving }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">EAN-code</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->EANcode }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Houdbaarheidsdatum</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ \Illuminate\Support\Carbon::parse($product->Houdbaarheidsdatum)->format('d-m-Y') }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Inkoopprijs</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">EUR {{ number_format($product->InkoopPrijs, 2, ',', '.') }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Verkoopprijs</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">EUR {{ number_format($product->VerkoopPrijs, 2, ',', '.') }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Aantal op voorraad</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->AantalOpVoorraad }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Leverancier</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->LeverancierNaam ?? '-' }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Postcode leverancier</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->LeverancierPostcode ?? '-' }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Plaats leverancier</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->LeverancierPlaats ?? '-' }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">E-mail leverancier</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->LeverancierEmail ?? '-' }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Mobiel leverancier</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->LeverancierMobiel ?? '-' }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-2 sm:gap-4">
                    <dt class="text-sm font-semibold text-zinc-700 dark:text-zinc-200">Opmerking</dt>
                    <dd class="text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Opmerking ?? '-' }}</dd>
                </div>
            </dl>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('producten.edit', $product->Id) }}" title="Product wijzigen" class="inline-flex items-center rounded-lg bg-red-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-800">
                    Wijzigen
                </a>
                <a href="{{ route('producten.index') }}" title="Terug naar productoverzicht" class="inline-flex items-center rounded-lg border border-blue-500 px-4 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-50 dark:hover:bg-blue-950/40">
                    Terug
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            setTimeout(function () {
                var melding = document.getElementById('success-melding');
                if (melding) {
                    melding.remove();
                }
            }, 3000);
        </script>
    @endif
</x-layouts::app>
