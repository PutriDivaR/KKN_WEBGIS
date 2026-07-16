@extends('layouts.app')

@section('title', $item['nama'] . ' — Perancangan Kawasan')

@section('content')

    <section class="max-w-6xl mx-auto px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="text-sm text-neutral-500 mb-4">
            <a href="{{ route('perancangan.index') }}" class="hover:text-green-700">Perancangan</a>
            <span class="mx-1.5">&rsaquo;</span>
            <span class="text-neutral-700">{{ $item['nama'] }}</span>
        </nav>

        <h1 class="text-2xl md:text-3xl font-bold text-green-900">{{ $item['nama'] }}</h1>
        <p class="mt-2 text-neutral-600 max-w-2xl">{{ $item['ringkasan'] }}</p>

        {{-- ============ SLIDER UTAMA: VIDEO 3D -> FOTO RENDER ============ --}}
        <div class="mt-6 relative rounded-2xl overflow-hidden h-72 md:h-[26rem] bg-neutral-900 border border-dashed border-green-900/20">

            @if ($item['video_3d'] || $item['foto_utama'])
                <div
                    id="mainSlider"
                    class="flex h-full transition-transform duration-500 ease-in-out"
                    style="width: {{ $item['video_3d'] && $item['foto_utama'] ? '200%' : '100%' }};"
                >
                    {{-- Slide 1: Video 3D (autoplay, loop, berhenti hanya kalau di-pause) --}}
                    @if ($item['video_3d'])
                        <div class="{{ $item['foto_utama'] ? 'w-1/2' : 'w-full' }} h-full shrink-0 relative bg-black group">
                            <video
                                id="mainVideo"
                                src="{{ $item['video_3d'] }}"
                                @if ($item['foto_utama']) poster="{{ $item['foto_utama'] }}" @endif
                                class="w-full h-full object-cover"
                                autoplay
                                muted
                                loop
                                playsinline
                                onerror="document.getElementById('videoErrorNotice')?.classList.remove('hidden'); this.classList.add('hidden');"
                            ></video>
                            <span id="videoErrorNotice" class="hidden absolute inset-0 items-center justify-center text-white/60 text-sm">
                                Video tidak ditemukan
                            </span>
                            
                            {{-- Custom Video Controls Overlay --}}
                            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent p-3 pt-8 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-auto">
                                {{-- Time Slider (Progress Bar) --}}
                                <div class="flex items-center w-full">
                                    <input 
                                        type="range" 
                                        id="videoSlider" 
                                        min="0" 
                                        max="100" 
                                        value="0" 
                                        step="0.1" 
                                        class="w-full h-1 bg-white/30 rounded-lg appearance-none cursor-pointer accent-green-600 hover:h-1.5 transition-all"
                                    >
                                </div>
                                {{-- Controls Bar --}}
                                <div class="flex items-center justify-between text-white text-xs">
                                    <div class="flex items-center gap-3">
                                        {{-- Play/Pause Button --}}
                                        <button type="button" id="videoPlayPauseBtn" class="hover:text-green-400 transition cursor-pointer" aria-label="Play/Pause">
                                            {{-- Pause Icon (default) --}}
                                            <svg id="pauseIcon" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                                            </svg>
                                            {{-- Play Icon (hidden initially) --}}
                                            <svg id="playIcon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </button>
                                        {{-- Mute/Unmute Button --}}
                                        <button type="button" id="videoMuteBtn" class="hover:text-green-400 transition cursor-pointer" aria-label="Mute/Unmute">
                                            {{-- Muted Icon (default since video is autoplay) --}}
                                            <svg id="muteIcon" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM12 4L9.91 6.09 12 8.18V4zm-8 4.73l2.27 2.27H3v6h4l5 5v-9.73l4.24 4.24c-.58.43-1.25.75-2 .88v2.06c1.3-.3 2.49-.97 3.47-1.87L18.73 21 20 19.73 5.27 5 4 6.27z"/>
                                            </svg>
                                            {{-- Unmuted Icon (hidden) --}}
                                            <svg id="unmuteIcon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                                            </svg>
                                        </button>
                                        <span class="text-[11px] bg-white/10 px-2 py-0.5 rounded text-white/90">Video 3D</span>
                                    </div>
                                    <span class="font-mono text-white/90" id="videoTimeLabel">00:00 / 00:00</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Slide 2: Foto render utama --}}
                    @if ($item['foto_utama'])
                        <div class="{{ $item['video_3d'] ? 'w-1/2' : 'w-full' }} h-full shrink-0 bg-green-900/5">
                            <img
                                src="{{ $item['foto_utama'] }}"
                                alt="{{ $item['nama'] }}"
                                class="w-full h-full object-cover cursor-zoom-in"
                                onclick="openImageModal('{{ $item['foto_utama'] }}', '{{ $item['nama'] }}')"
                                onerror="this.style.display='none'"
                            >
                        </div>
                    @endif
                </div>

                {{-- Tombol & indikator titik hanya muncul kalau ADA 2 slide (video + foto) --}}
                @if ($item['video_3d'] && $item['foto_utama'])
                    <button
                        type="button"
                        id="slidePrevBtn"
                        onclick="moveSlide(-1)"
                        class="hidden absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 shadow flex items-center justify-center text-green-800 hover:bg-white"
                        aria-label="Kembali ke video"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    <button
                        type="button"
                        id="slideNextBtn"
                        onclick="moveSlide(1)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 shadow flex items-center justify-center text-green-800 hover:bg-white"
                        aria-label="Lihat foto render"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>

                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5">
                        <span id="slideDot-0" class="w-2 h-2 rounded-full bg-white"></span>
                        <span id="slideDot-1" class="w-2 h-2 rounded-full bg-white/40"></span>
                    </div>
                @endif
            @else
                <div class="w-full h-full flex items-center justify-center text-white/50 text-sm">
                    Belum ada media untuk perancangan ini
                </div>
            @endif
        </div>

        {{-- ============ GALERI (KIRI) + NARASI (KANAN) ============ --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

            {{-- Galeri Render --}}
            <div class="rounded-2xl border border-neutral-200 p-4">
                <p class="font-semibold text-green-900 mb-3">Galeri Perancangan</p>

                @if (count($item['galeri']))
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-[26rem] overflow-y-auto pr-1">
                        @foreach ($item['galeri'] as $foto)
                            <button
                                type="button"
                                onclick="openImageModal('{{ $foto['src'] }}', '{{ $foto['nama'] }}')"
                                class="group text-left rounded-xl overflow-hidden border border-dashed border-green-900/20 bg-green-900/5 hover:border-green-900/40 transition cursor-pointer"
                            >
                                <div class="h-24 overflow-hidden bg-green-900/5 relative">
                                    <img
                                        src="{{ $foto['src'] }}"
                                        alt="{{ $foto['nama'] }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                        onerror="this.style.display='none'"
                                    >
                                    {{-- Hover zoom icon --}}
                                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-white drop-shadow-sm">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-[11px] text-neutral-600 px-2 py-1.5 truncate" title="{{ $foto['nama'] }}">
                                    {{ $foto['nama'] }}
                                </p>
                            </button>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-neutral-400">Belum ada foto render untuk perancangan ini.</p>
                @endif
            </div>

            {{-- Konsep --}}
            <div class="rounded-2xl border border-neutral-200 p-4">
                <p class="font-semibold text-green-900 mb-3">Konsep Perancangan</p>
                <p class="text-sm text-neutral-600 leading-relaxed">{{ $item['narasi'] }}</p>

                <dl class="mt-4 space-y-2 text-sm">
                    @foreach ([
                        'Fungsi'          => $item['fungsi'],
                        'Luas Area'       => $item['luas_area'],
                        'Material Utama'  => $item['material'],
                        'Konsep'          => $item['konsep'],
                    ] as $label => $value)
                        <div class="flex gap-3">
                            <dt class="text-neutral-500 w-32 shrink-0">{{ $label }}</dt>
                            <dd class="text-neutral-800">: {{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

        </div>
    </section>

    {{-- ============ MODAL POPUP GAMBAR ============ --}}
    <div
        id="imageModal"
        class="opacity-0 pointer-events-none fixed inset-0 z-50 bg-black/85 backdrop-blur-sm flex items-center justify-center p-4 transition-all duration-300 ease-in-out"
        onclick="closeImageModalBackdrop(event)"
    >
        <div id="modalContainer" class="relative max-w-4xl w-full scale-95 transition-all duration-300 ease-in-out">
            <button
                type="button"
                onclick="closeImageModal()"
                class="absolute -top-10 right-0 text-white/80 hover:text-white text-sm flex items-center gap-1 transition-colors cursor-pointer"
                aria-label="Tutup"
            >
                Tutup
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="modalImage" src="" alt="" class="w-full max-h-[80vh] object-contain rounded-xl bg-black border border-white/10 shadow-2xl">
            <p id="modalCaption" class="mt-3 text-center text-white/95 font-medium text-sm drop-shadow-md"></p>
        </div>
    </div>

    @vite('resources/js/perancangan.js')

@endsection