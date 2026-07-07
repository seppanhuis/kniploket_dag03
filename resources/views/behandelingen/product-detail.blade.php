<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">

        @if (session('success'))
            <div id="success-banner" class="max-w-3xl rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <nav class="text-sm text-zinc-500 dark:text-zinc-400">
            <a href="{{ route('dashboard') }}" class="font-medium text-red-700 hover:underline dark:text-red-400">Home</a>
            <span class="mx-1">/</span>
            <a href="{{ route('behandelingen.producten', $behandelingId) }}" class="font-medium text-red-700 hover:underline dark:text-red-400">Behandelingen</a>
            <span class="mx-1">/</span>
            <span class="text-zinc-400 dark:text-zinc-500">Detail</span>
        </nav>

        <h1 class="text-2xl font-semibold tracking-tight">
            <span class="text-red-700 dark:text-red-400">Productdetail</span>
            <span class="text-zinc-500 dark:text-zinc-400">{{ $product->Naam }}</span>
        </h1>

        <div class="max-w-3xl overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <dl class="divide-y divide-zinc-200 dark:divide-zinc-800">
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Product</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Naam }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Merk</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Merk }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Omschrijving</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Omschrijving }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">EAN-code</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->EANcode }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Houdbaarheidsdatum</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ \Carbon\Carbon::parse($product->Houdbaarheidsdatum)->format('d-m-Y') }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Inkoopprijs</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">EUR {{ number_format($product->InkoopPrijs, 2, ',', '.') }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Verkoopprijs</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">EUR {{ number_format($product->VerkoopPrijs, 2, ',', '.') }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Aantal op voorraad</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->AantalOpVoorraad }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Leverancier</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->LeverancierNaam }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Postcode leverancier</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->LeverancierPostcode }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Plaats leverancier</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->LeverancierPlaats }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">E-mail leverancier</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->LeverancierEmail }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Mobiel leverancier</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->LeverancierMobiel }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Opmerking</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $product->Opmerking ?? 'Geschikt voor dagelijks salongebruik' }}</dd>
                </div>
            </dl>

            <div class="flex justify-end gap-3 border-t border-zinc-200 p-4 dark:border-zinc-800">
                <a href="{{ route('behandelingen.producten.edit', [$behandelingId, $product->Id]) }}" title="Product wijzigen" class="inline-flex items-center rounded-lg bg-red-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-800">
                    Wijzigen
                </a>
                <a href="{{ route('behandelingen.producten', $behandelingId) }}" title="Terug naar productenoverzicht" class="inline-flex items-center rounded-lg border border-blue-500 px-4 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-50 dark:hover:bg-blue-950/40">
                    Terug
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            setTimeout(function () {
                var banner = document.getElementById('success-banner');
                if (banner) {
                    banner.remove();
                }
            }, 3000);
        </script>
    @endif
</x-layouts::app>
