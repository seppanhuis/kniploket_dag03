<x-layouts::app :title="__('Eigenaar')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl bg-zinc-100 p-4 dark:bg-zinc-950 sm:p-6 lg:p-8">
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 sm:p-8">
            <div>
                <nav class="mb-3 text-sm font-medium text-[#C8102E] dark:text-red-300">Home</nav>

                <span class="inline-flex items-center rounded-full bg-amber-400 px-3 py-1 text-xs font-semibold text-zinc-900">
                    Kapsalon applicatie
                </span>

                <h1 class="mt-3 text-3xl font-bold text-zinc-900 dark:text-white">Eigenaar</h1>
                <p class="mt-1 text-sm font-medium text-zinc-500 dark:text-zinc-400">Home</p>
                <p class="mt-2 max-w-3xl text-sm text-zinc-500 dark:text-zinc-400">
                    Welkom bij Kniploket Tiko - hier regel je eenvoudig klanten, afspraken en planning voor de salon.
                </p>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $cards = [
                        ['title' => 'Accounts', 'desc' => 'Beheer gebruikersaccounts en roltoewijzingen.', 'href' => '#'],
                        ['title' => 'Medewerkers', 'desc' => 'Overzicht van medewerkers en hun basisgegevens.', 'href' => route('medewerkers.index')],
                        ['title' => 'Beschikbaarheid', 'desc' => 'Bekijk de beschikbaarheid van medewerkers per dag en tijd.', 'href' => '#'],
                        ['title' => 'Klanten', 'desc' => 'Bekijk en filter klantgegevens op postcode en contactinformatie.', 'href' => '#'],
                        ['title' => 'Afspraken', 'desc' => 'Plan, bekijk en beheer afspraken met status en tijd.', 'href' => route('afspraken.index')],
                        ['title' => 'Behandelingen', 'desc' => 'Overzicht van behandelingen, duur en prijsinformatie.', 'href' => route('behandelingen.index')],
                        ['title' => 'Producten', 'desc' => 'Bekijk en beheer producten binnen het assortiment.', 'href' => route('producten.index')],
                        ['title' => 'Bestellingen', 'desc' => 'Bekijk en beheer klantbestellingen en bestelstatus.', 'href' => '#'],
                    ];
                @endphp

                @foreach ($cards as $card)
                    @php $isLink = $card['href'] !== '#'; @endphp
                    <div class="flex flex-col justify-between rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <div>
                            <h2 class="text-base font-semibold text-zinc-900 dark:text-white">{{ $card['title'] }}</h2>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $card['desc'] }}</p>
                        </div>
                        <a href="{{ $card['href'] }}" {{ $isLink ? 'wire:navigate' : '' }} class="mt-4 inline-flex w-fit items-center rounded-lg border border-[#166ad8] px-4 py-1.5 text-sm font-medium text-[#166ad8] transition hover:bg-[#166ad8] hover:text-white dark:border-blue-300 dark:text-blue-300">Openen</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts::app>
