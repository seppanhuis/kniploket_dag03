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
            <a href="{{ route('medewerkers.index') }}" class="font-medium text-red-700 hover:underline dark:text-red-400">Medewerkers</a>
            <span class="mx-1">/</span>
            <span class="text-zinc-400 dark:text-zinc-500">Wijzigen</span>
        </nav>

        <h1 class="text-2xl font-semibold tracking-tight">
            <span class="text-red-700 dark:text-red-400">Medewerker wijzigen</span>
            <span class="text-zinc-500 dark:text-zinc-400">{{ $medewerker->VolledigeNaam }}</span>
        </h1>

        <form method="POST" action="{{ route('medewerkers.update', $medewerker->Id) }}" class="max-w-4xl rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="naam" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Naam <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="naam" name="naam" value="{{ old('naam', $medewerker->VolledigeNaam) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="specialisatie" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Specialisatie <span class="text-rose-600">*</span>
                    </label>
                    <select
                        id="specialisatie"
                        name="specialisatie"
                        class="block w-full rounded-xl px-4 py-2.5 text-zinc-900 shadow-sm focus:ring-zinc-900 dark:bg-zinc-950 dark:text-zinc-100 {{ $errors->has('specialisatie') ? 'border-rose-500 focus:border-rose-500 ring-1 ring-rose-500' : 'border-zinc-300 focus:border-zinc-900 dark:border-zinc-700' }}"
                    >
                        @foreach ($specialisaties as $specialisatie)
                            <option value="{{ $specialisatie }}" @selected(old('specialisatie', $medewerker->Specialisatie) === $specialisatie)>{{ $specialisatie }}</option>
                        @endforeach
                    </select>
                    @error('specialisatie')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="geboortedatum" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Geboortedatum <span class="text-rose-600">*</span>
                    </label>
                    <input type="date" id="geboortedatum" name="geboortedatum" value="{{ old('geboortedatum', \Carbon\Carbon::parse($medewerker->Geboortedatum)->format('Y-m-d')) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="contact_email" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Contact e-mail <span class="text-rose-600">*</span>
                    </label>
                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $medewerker->ContactEmail) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Account e-mail</label>
                    <input type="text" value="{{ $medewerker->AccountEmail }}" readonly class="block w-full cursor-not-allowed rounded-xl border-zinc-300 bg-zinc-100 px-4 py-2.5 text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                </div>

                <div>
                    <label for="straatnaam" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Straatnaam <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="straatnaam" name="straatnaam" value="{{ old('straatnaam', $medewerker->Straatnaam) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div class="grid grid-cols-1 gap-5 sm:col-span-2 sm:grid-cols-3">
                    <div>
                        <label for="huisnummer" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                            Huisnummer <span class="text-rose-600">*</span>
                        </label>
                        <input type="number" min="1" id="huisnummer" name="huisnummer" value="{{ old('huisnummer', $medewerker->Huisnummer) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                    </div>

                    <div>
                        <label for="toevoeging" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Toevoeging</label>
                        <input type="text" id="toevoeging" name="toevoeging" value="{{ old('toevoeging', $medewerker->Toevoeging) }}" class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                    </div>

                    <div>
                        <label for="postcode" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                            Postcode <span class="text-rose-600">*</span>
                        </label>
                        <input type="text" id="postcode" name="postcode" value="{{ old('postcode', $medewerker->Postcode) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                    </div>
                </div>

                <div>
                    <label for="plaats" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Plaats <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="plaats" name="plaats" value="{{ old('plaats', $medewerker->Plaats) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div>
                    <label for="mobiel" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">
                        Mobiel <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" id="mobiel" name="mobiel" value="{{ old('mobiel', $medewerker->Mobiel) }}" required class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>

                <div class="sm:col-span-2">
                    <label for="opmerking" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Opmerking</label>
                    <input type="text" id="opmerking" name="opmerking" value="{{ old('opmerking', $medewerker->Opmerking) }}" class="block w-full rounded-xl border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100">
                </div>
            </div>

            <p class="mt-5 text-xs text-zinc-500 dark:text-zinc-400">Velden met een <span class="text-rose-600">*</span> zijn verplicht.</p>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center rounded-xl bg-red-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-800">
                    Opslaan
                </button>
                <a href="{{ route('medewerkers.show', $medewerker->Id) }}" class="inline-flex items-center rounded-xl bg-zinc-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-600">
                    Terug
                </a>
            </div>
        </form>
    </div>
</x-layouts::app>
