<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-100 dark:bg-zinc-950">
        <flux:header container class="border-b border-red-900/30 bg-[#C8102E] px-4 sm:px-6">
            <flux:sidebar.toggle class="lg:hidden mr-2 text-white" icon="bars-2" inset="left" />

            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center whitespace-nowrap text-lg font-black tracking-wide text-white">
                KNIPLOKET TIKO
            </a>

            <nav class="ms-6 hidden items-center gap-1 lg:flex">
                @php
                    $navItems = [
                        ['label' => 'Accounts', 'href' => '#', 'active' => false],
                        ['label' => 'Medewerkers', 'href' => '#', 'active' => false],
                        ['label' => 'Beschikbaarheid', 'href' => '#', 'active' => false],
                        ['label' => 'Klanten', 'href' => '#', 'active' => false],
                        ['label' => 'Afspraken', 'href' => route('afspraken.index'), 'active' => request()->routeIs('afspraken.*')],
                        ['label' => 'Behandelingen', 'href' => '#', 'active' => false],
                        ['label' => 'Producten', 'href' => '#', 'active' => false],
                        ['label' => 'Bestellingen', 'href' => '#', 'active' => false],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <a href="{{ $item['href'] }}" @if ($item['href'] !== '#') wire:navigate @endif class="rounded-md px-2 py-1.5 text-sm font-bold text-white hover:bg-white/10 {{ $item['active'] ? 'bg-white/20' : '' }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>

            <flux:spacer />

            <div class="hidden items-center gap-3 sm:flex">
                <span class="inline-flex items-center gap-1 whitespace-nowrap text-sm font-semibold text-white">
                    <span>{{ auth()->user()->name ?? 'Salon Eigenaar' }}</span>
                    <span>({{ auth()->user()->role ?? 'eigenaar' }})</span>
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg border border-white/50 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-white/10">
                        {{ __('Uitloggen') }}
                    </button>
                </form>
            </div>
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <a href="{{ route('dashboard') }}" wire:navigate class="whitespace-nowrap text-base font-black text-[#C8102E] dark:text-red-300">
                    KNIPLOKET TIKO
                </a>
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Home') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="calendar" :href="route('afspraken.index')" :current="request()->routeIs('afspraken.*')" wire:navigate>
                        {{ __('Afspraken') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>
        </flux:sidebar>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist
        @fluxScripts
    </body>
</html>
