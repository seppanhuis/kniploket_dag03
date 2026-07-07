<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6 lg:p-8">

        @if (session('success'))
            <div id="success-banner" class="max-w-3xl rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <nav class="text-sm text-zinc-500 dark:text-zinc-400">
            <a href="{{ route('dashboard') }}" title="Naar het dashboard" class="font-medium text-red-700 hover:underline dark:text-red-400">Home</a>
            <span class="mx-1">/</span>
            <a href="{{ route('medewerkers.index') }}" title="Naar het medewerkeroverzicht" class="font-medium text-red-700 hover:underline dark:text-red-400">Medewerkers</a>
            <span class="mx-1">/</span>
            <span class="text-zinc-400 dark:text-zinc-500">Detail</span>
        </nav>

        <h1 class="text-2xl font-semibold tracking-tight">
            <span class="text-red-700 dark:text-red-400">Medewerkerdetail</span>
            <span class="text-zinc-500 dark:text-zinc-400">{{ $medewerker->VolledigeNaam }}</span>
        </h1>

        <div class="max-w-3xl overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <dl class="divide-y divide-zinc-200 dark:divide-zinc-800">
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Naam</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->VolledigeNaam }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Specialisatie</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->Specialisatie }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Geboortedatum</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ \Carbon\Carbon::parse($medewerker->Geboortedatum)->format('d-m-Y') }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Contact e-mail</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->ContactEmail }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Account e-mail</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->AccountEmail }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Straatnaam</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->Straatnaam }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Huisnummer</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->Huisnummer }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Toevoeging</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->Toevoeging ?? '-' }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Postcode</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->Postcode }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Plaats</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->Plaats }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Mobiel</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->Mobiel }}</dd>
                </div>
                <div class="grid grid-cols-3 gap-4 px-6 py-3">
                    <dt class="text-sm font-medium text-zinc-700 dark:text-zinc-200">Opmerking</dt>
                    <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $medewerker->Opmerking ?? '-' }}</dd>
                </div>
            </dl>

            <div class="flex justify-end gap-3 border-t border-zinc-200 p-4 dark:border-zinc-800">
                <a href="{{ route('medewerkers.edit', $medewerker->Id) }}" title="Medewerker wijzigen" class="inline-flex items-center rounded-lg bg-red-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-800">
                    Wijzigen
                </a>
                <a href="{{ route('medewerkers.index') }}" title="Terug naar medewerkeroverzicht" class="inline-flex items-center rounded-lg border border-blue-500 px-4 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-50 dark:hover:bg-blue-950/40">
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
