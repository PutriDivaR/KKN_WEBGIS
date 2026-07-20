


<header class="sticky top-0 z-[9999] bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between">

        {{-- Logo --}}
        {{-- LOGO --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">

            {{-- Ganti dengan logo asli --}}
            <img
                src="{{ asset('assets/logo.png') }}"
                alt="Logo Kampung Adat"
                class="w-11 h-11 object-contain"
            >

            <div class="leading-tight">
                <h1 class="text-[14px] font-semibold text-gray-900">
                    Kampung Adat
                </h1>

                <p class="text-[12px] text-gray-500">
                    Muaro Sijunjung
                </p>
            </div>

        </a>

        {{-- Desktop nav --}}
        <nav class="hidden md:flex items-center gap-9 text-sm font-medium">
            @php
                $links = [
                    ['label' => 'Beranda',      'route' => 'home'],
                    ['label' => 'Peta',         'route' => 'map'],
                    ['label' => 'Fasilitas',    'route' => 'fasilitas.index'],
                    ['label' => 'Perancangan',  'route' => 'perancangan.index'],
                    ['label' => 'Tentang',      'route' => 'tentang'],
                ];
            @endphp

            @foreach ($links as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="relative py-2 transition-colors
                        {{ request()->routeIs($link['route']) || request()->routeIs($link['route'] . '.*') ? 'text-green-700' : 'text-neutral-600 hover:text-green-700' }}"
                >
                    {{ $link['label'] }}
                    @if (request()->routeIs($link['route']) || request()->routeIs($link['route'] . '.*'))
                        <span class="absolute left-0 -bottom-[1px] w-full h-0.5 bg-green-600 rounded-full"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- Mobile menu button --}}
        <button
            type="button"
            onclick="document.getElementById('mobile-nav').classList.toggle('hidden')"
            class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg border border-neutral-200 text-neutral-700"
            aria-label="Buka menu"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    {{-- Mobile nav --}}
    <div id="mobile-nav" class="hidden md:hidden border-t border-black/5 bg-white px-6 py-4 space-y-3">
        @foreach ($links as $link)
            <a
                href="{{ route($link['route']) }}"
                class="block text-sm font-medium {{ request()->routeIs($link['route']) || request()->routeIs($link['route'] . '.*') ? 'text-green-700' : 'text-neutral-600' }}"
            >
                {{ $link['label'] }}
            </a>
        @endforeach
    </div>
</header>