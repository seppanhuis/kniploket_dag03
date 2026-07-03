<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl bg-zinc-100 p-4 dark:bg-zinc-950 sm:p-6 lg:p-8">

        <nav class="text-sm">
            <a href="{{ route('dashboard') }}" wire:navigate class="font-medium text-[#C8102E] hover:underline dark:text-red-300">Home</a>
            <span class="text-zinc-400"> / </span>
            <a href="{{ route('afspraken.index') }}" wire:navigate class="font-medium text-[#C8102E] hover:underline dark:text-red-300">Afspraken</a>
            <span class="text-zinc-400"> / </span>
            <span class="text-zinc-500 dark:text-zinc-400">Detail</span>
        </nav>

        <h1 class="text-2xl font-bold text-[#C8102E] dark:text-red-300">
            Afspraakdetail <span class="text-zinc-900 dark:text-white">{{ $afspraak->KlantNaam }}</span>
        </h1>

        <div class="max-w-2xl overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <dl class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @php
                    $rows = [
                        'Klant' => $afspraak->KlantNaam,
                        'Relatienummer' => $afspraak->Relatienummer,
                        'Mobiel' => $afspraak->Mobiel,
                        'Contact e-mail' => $afspraak->Email,
                        'Medewerker' => $afspraak->MedewerkerNaam,
                        'Behandeling' => $afspraak->BehandelingNaam,
                        'Datum' => \Illuminate\Support\Carbon::parse($afspraak->Datum)->format('d-m-Y'),
                        'Starttijd' => \Illuminate\Support\Carbon::parse($afspraak->Starttijd)->format('H:i'),
                        'Duur' => $afspraak->Duurminuten . ' min',
                        'Eindtijd' => \Illuminate\Support\Carbon::parse($afspraak->Eindtijd)->format('H:i'),
                        'Status' => $afspraak->Afspraakstatus,
                    ];
                @endphp
                @foreach ($rows as $label => $value)
                    <div class="grid grid-cols-3 gap-4 px-5 py-3">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ $label }}</dt>
                        <dd class="col-span-2 text-sm text-zinc-900 dark:text-zinc-100">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>

            <div class="flex justify-end gap-3 border-t border-zinc-200 px-5 py-4 dark:border-zinc-800">
                <a href="{{ route('afspraken.edit', $afspraak->Id) }}" wire:navigate title="Afspraak wijzigen"
                    class="inline-flex items-center rounded-lg bg-[#C8102E] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#a80d26]">
                    Wijzigen
                </a>
                <a href="{{ route('afspraken.index') }}" wire:navigate title="Terug naar overzicht afspraken"
                    class="inline-flex items-center rounded-lg border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    Terug
                </a>
            </div>
        </div>
    </div>
</x-layouts::app>
