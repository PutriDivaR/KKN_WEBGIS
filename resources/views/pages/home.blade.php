@extends('layouts.app')

@section('title', 'Beranda — WebGIS Kampung Adat Sijunjung')

@section('content')

    @php

        $iconPaths = [
            'home' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
            'users' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
            'landmark' => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z',
            'book' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
        ];

        $iconFor = function (string $text) {
            $text = mb_strtolower($text);
            return match (true) {
                str_contains($text, 'rumah')     => 'home',
                str_contains($text, 'suku')       => 'users',
                str_contains($text, 'fasilitas')  => 'landmark',
                default                            => 'book',
            };
        };
    @endphp

    {{-- wallpaper beranda --}}
    <section class="relative h-[92vh] min-h-[560px] flex items-end overflow-hidden bg-green-950">

    <img
        src="{{ asset('assets/wallpaper_beranda.jpeg') }}"
        alt="Rumah Gadang Kampung Adat Sijunjung"
        class="absolute inset-0 w-full h-full object-cover object-[center_10%] scale-105"
    >

        <div class="absolute inset-0 bg-gradient-to-t from-green-950/90 via-green-950/50 to-green-950/20"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 pb-28 text-white w-full">
            <p class="text-xs tracking-[0.25em] uppercase text-green-300 mb-4">Kampung Adat Muaro Sijunjung</p>
            <h1 class="text-4xl md:text-6xl font-bold leading-tight max-w-3xl">
                Sistem Informasi<br class="hidden md:block"> Kampung Adat Sijunjung
            </h1>
            <p class="mt-6 text-lg text-green-100/90 max-w-xl">
                Menjelajahi dan melestarikan warisan budaya melalui informasi dan peta interaktif.
            </p>
            <a
                href="{{ route('map') }}"
                class="inline-block mt-8 px-8 py-3 bg-green-600 hover:bg-green-500 transition-colors rounded-xl font-medium"
            >
                Jelajahi Peta
            </a>
        </div>
    </section>

    {{-- ============ STATS (floating card) ============ --}}
    <section class="relative z-10 -mt-14 px-6 lg:px-8">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-xl grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-neutral-100">
            @foreach ($stats as $stat)
                <div class="p-6 flex items-center gap-4">
                    <div class="w-11 h-11 shrink-0 rounded-xl bg-green-50 text-green-700 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPaths[$iconFor($stat['label'])] }}" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-900 leading-none">{{ $stat['value'] }}</p>
                        <p class="text-sm text-neutral-500 mt-1">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

{{-- ============ INFORMASI KAMPUNG ADAT ============ --}}
<section class="max-w-7xl mx-auto px-6 lg:px-8 py-16">

    <div class="grid lg:grid-cols-12 gap-8 items-stretch">

        {{-- KIRI --}}
        <div class="lg:col-span-4 flex flex-col justify-between">

            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Informasi Kampung Adat
                </h2>

                <p class="text-gray-600 leading-7 text-justify">
                    Kampung Adat Sijunjung merupakan kawasan permukiman adat
                    Minangkabau yang memiliki nilai sejarah, budaya, dan
                    arsitektur yang tinggi. Kawasan ini masih mempertahankan
                    bentuk rumah gadang, tradisi adat, serta kehidupan sosial
                    masyarakat secara turun-temurun.
                </p>
            </div>

            <a href="{{ route('tentang') }}"
                class="inline-flex items-center gap-2 text-green-700 font-semibold mt-6 hover:text-green-800">

                Lihat Selengkapnya

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7"/>

                </svg>

            </a>

        </div>

        {{-- KANAN --}}
        <div class="lg:col-span-8">

            <div class="grid md:grid-cols-3 gap-5 h-full">

                @foreach($infoCards as $card)

                <div
                    class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition duration-300 flex flex-col">

                    <div
                        class="w-14 h-14 rounded-xl bg-green-50 flex items-center justify-center text-green-700 mb-5">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-7 h-7">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="{{ $iconPaths[$iconFor($card['title'])] }}" />

                        </svg>

                    </div>

                    <h3 class="font-semibold text-gray-900 text-lg mb-3">
                        {{ $card['title'] }}
                    </h3>

                    <p class="text-gray-600 text-sm leading-6 flex-grow">
                        {{ $card['desc'] }}
                    </p>

                    <a href="{{ $card['url'] }}"
                        class="mt-6 inline-flex items-center gap-2 text-green-700 font-medium hover:text-green-800">

                        Lihat Selengkapnya

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"/>

                        </svg>

                    </a>

                </div>

                @endforeach

            </div>

        </div>

    </div>

</section>

    {{-- ============ GALERI TERBARU ============ --}}
    <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-24">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-green-900">Galeri Terbaru</h2>
            <a href="{{ route('map') }}" class="text-green-700 font-medium hover:underline">
                Lihat Semua →
            </a>
        </div>

        <div class="relative">
            <div id="galeri-scroll" class="flex gap-4 overflow-x-auto pb-2 snap-x snap-mandatory scroll-smooth [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                @forelse ($gallery as $photo)
                    <figure class="shrink-0 w-52 md:w-64 snap-start">
                        <div class="w-full h-64 rounded-xl bg-green-900/5 border border-dashed border-green-900/20 flex items-end overflow-hidden">
                            <img
                                src="{{ $photo['image'] }}"
                                alt="{{ $photo['name'] }}"
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'"
                            >
                        </div>
                        <figcaption class="mt-2 text-sm text-neutral-600">{{ $photo['name'] }}</figcaption>
                    </figure>
                @empty
                    <p class="text-sm text-neutral-500 py-10">Belum ada foto rumah adat maupun fasilitas yang diunggah.</p>
                @endforelse
            </div>

            {{-- Tombol navigasi galeri --}}
            <button
                type="button"
                onclick="document.getElementById('galeri-scroll').scrollBy({ left: -280, behavior: 'smooth' })"
                class="hidden md:flex absolute -left-4 top-[45%] -translate-y-1/2 w-9 h-9 rounded-full bg-white shadow-md items-center justify-center text-green-800 hover:bg-green-50"
                aria-label="Sebelumnya"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <button
                type="button"
                onclick="document.getElementById('galeri-scroll').scrollBy({ left: 280, behavior: 'smooth' })"
                class="hidden md:flex absolute -right-4 top-[45%] -translate-y-1/2 w-9 h-9 rounded-full bg-white shadow-md items-center justify-center text-green-800 hover:bg-green-50"
                aria-label="Selanjutnya"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </section>

@endsection 