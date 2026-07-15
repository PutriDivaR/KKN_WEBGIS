<header class="sticky top-0 z-50 bg-white shadow-sm">

    <div class="max-w-7xl mx-auto h-[72px] px-6 lg:px-8 flex items-center justify-between">

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


        @php
            $links = [
                ['label'=>'Beranda','route'=>'home'],
                ['label'=>'Peta','route'=>'map'],
                ['label'=>'Fasilitas','route'=>'fasilitas.index'],
                ['label'=>'Tentang','route'=>'tentang'],
            ];
        @endphp


        {{-- MENU --}}
        <nav class="hidden md:flex items-center gap-12">

            @foreach($links as $link)

                <a href="{{ route($link['route']) }}"
                   class="relative py-6 text-[15px] font-medium transition">

                    <span class="{{ request()->routeIs($link['route'])
                        ? 'text-green-700 font-semibold'
                        : 'text-gray-700 hover:text-green-700' }}">

                        {{ $link['label'] }}

                    </span>

                    @if(request()->routeIs($link['route']))

                        <span
                            class="absolute bottom-4 left-1/2 -translate-x-1/2
                                   w-8 h-[3px] rounded-full bg-green-600">
                        </span>

                    @endif

                </a>

            @endforeach

        </nav>


        {{-- MOBILE --}}
        <button
            onclick="document.getElementById('mobile-nav').classList.toggle('hidden')"
            class="md:hidden w-10 h-10 flex items-center justify-center rounded-lg border border-gray-200">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-6 h-6"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>

            </svg>

        </button>

    </div>


    {{-- MOBILE MENU --}}
    <div id="mobile-nav"
         class="hidden md:hidden bg-white border-t">

        @foreach($links as $link)

            <a href="{{ route($link['route']) }}"
               class="block px-6 py-4 text-sm font-medium {{ request()->routeIs($link['route']) ? 'text-green-700 bg-green-50' : 'text-gray-700' }}">

                {{ $link['label'] }}

            </a>

        @endforeach

    </div>

</header>