<x-layouts::app :title="$title">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl bg-zinc-100 p-4 dark:bg-zinc-950 sm:p-6 lg:p-8">

        @if (session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 dark:border-rose-900/60 dark:bg-rose-950/40 dark:text-rose-200">
                {{ session('error') }}
            </div>
        @endif

        <nav class="text-sm">
            <a href="{{ route('dashboard') }}" wire:navigate class="font-medium text-[#C8102E] hover:underline dark:text-red-300">Home</a>
            <span class="text-zinc-400"> / </span>
            <a href="{{ route('afspraken.index') }}" wire:navigate class="font-medium text-[#C8102E] hover:underline dark:text-red-300">Afspraken</a>
            <span class="text-zinc-400"> / </span>
            <span class="text-zinc-500 dark:text-zinc-400">Wijzigen</span>
        </nav>

        <h1 class="text-2xl font-bold text-[#C8102E] dark:text-red-300">
            Afspraak wijzigen <span class="text-zinc-900 dark:text-white">{{ $afspraak->KlantNaam }}</span>
        </h1>

        <form method="POST" action="{{ route('afspraken.update', $afspraak->Id) }}" class="max-w-3xl rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Klant</label>
                    <input type="text" value="{{ $afspraak->KlantNaam }}" disabled
                        class="block w-full rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Relatienummer</label>
                    <input type="text" value="{{ $afspraak->Relatienummer }}" disabled
                        class="block w-full rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Contact e-mail</label>
                    <input type="text" value="{{ $afspraak->Email }}" disabled
                        class="block w-full rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Mobiel</label>
                    <input type="text" value="{{ $afspraak->Mobiel }}" disabled
                        class="block w-full rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-400">
                </div>

                <div>
                    <label for="medewerker_id" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Medewerker *</label>
                    <select id="medewerker_id" name="medewerker_id" required
                        class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                        @foreach ($medewerkers as $medewerker)
                            <option value="{{ $medewerker->Id }}" @selected((int) old('medewerker_id', $afspraak->MedewerkerId) === $medewerker->Id)>
                                {{ $medewerker->VolledigeNaam }}
                            </option>
                        @endforeach
                    </select>
                    @error('medewerker_id')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="behandeling_id" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Behandeling *</label>
                    <select id="behandeling_id" name="behandeling_id" required
                        class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                        @foreach ($behandelingen as $behandeling)
                            <option value="{{ $behandeling->Id }}" data-duur="{{ $behandeling->Duurminuten }}"
                                @selected((int) old('behandeling_id', $afspraak->BehandelingId) === $behandeling->Id)>
                                {{ $behandeling->Naam }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="datum" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Datum *</label>
                    <input type="date" id="datum" name="datum" required
                        value="{{ old('datum', \Illuminate\Support\Carbon::parse($afspraak->Datum)->format('Y-m-d')) }}"
                        class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                    @error('datum')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="starttijd" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Starttijd *</label>
                    <input type="time" id="starttijd" name="starttijd" required
                        value="{{ old('starttijd', \Illuminate\Support\Carbon::parse($afspraak->Starttijd)->format('H:i')) }}"
                        class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                    @error('starttijd')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Duur</label>
                    <input type="text" id="duur" value="{{ $afspraak->Duurminuten }} min" disabled
                        class="block w-full rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-400">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Eindtijd</label>
                    <input type="text" id="eindtijd" value="{{ \Illuminate\Support\Carbon::parse($afspraak->Eindtijd)->format('H:i') }}" disabled
                        class="block w-full rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-400">
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Status *</label>
                    <select id="status" name="status" required
                        class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                        @foreach ($statussen as $status)
                            <option value="{{ $status }}" @selected(old('status', $afspraak->Afspraakstatus) === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <p class="mt-4 text-xs text-zinc-500 dark:text-zinc-400">Velden met een * zijn verplicht.</p>

            <div class="mt-6 flex flex-wrap justify-end gap-3">
                <button type="submit" title="Wijzigingen opslaan" class="inline-flex items-center rounded-xl bg-[#C8102E] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#a80d26]">
                    Opslaan
                </button>
                <a href="{{ route('afspraken.show', $afspraak->Id) }}" wire:navigate title="Terug naar afspraakdetail"
                    class="inline-flex items-center rounded-xl border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    Terug
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const behandelingSelect = document.getElementById('behandeling_id');
            const starttijdInput = document.getElementById('starttijd');
            const duurInput = document.getElementById('duur');
            const eindtijdInput = document.getElementById('eindtijd');

            function berekenEindtijd() {
                const optie = behandelingSelect.options[behandelingSelect.selectedIndex];
                const duur = parseInt(optie.dataset.duur || '0', 10);
                duurInput.value = duur + ' min';

                if (starttijdInput.value) {
                    const [uur, minuut] = starttijdInput.value.split(':').map(Number);
                    const start = new Date(2000, 0, 1, uur, minuut);
                    start.setMinutes(start.getMinutes() + duur);
                    eindtijdInput.value =
                        String(start.getHours()).padStart(2, '0') + ':' +
                        String(start.getMinutes()).padStart(2, '0');
                }
            }

            behandelingSelect.addEventListener('change', berekenEindtijd);
            starttijdInput.addEventListener('change', berekenEindtijd);
        });
    </script>
</x-layouts::app>
