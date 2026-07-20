@extends('layouts.app')

@section('title', $rumah->nama_tampil . ' — WebGIS Kampung Adat Sijunjung')

@push('styles')
    @if ($rumah->has_lokasi)
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
        <style>#lokasi-map { background: #e9ede9; }</style>
    @endif
@endpush

@section('content')

    @php
        $icons = [
            'home'  => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
            'users' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
            'tag'   => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.31a10.452 10.452 0 003.233-3.233c.562-.827.39-1.908-.31-2.607L9.19 3.66A2.25 2.25 0 007.6 3H9.568zM6 6h.008v.008H6V6z',
            'pin'   => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z',
            'arrow' => 'M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18',
            'info'  => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
            'book'  => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
            'photo' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 6.75h18M3 6.75A2.25 2.25 0 015.25 4.5h13.5A2.25 2.25 0 0121 6.75m-18 0v10.5A2.25 2.25 0 005.25 19.5h13.5A2.25 2.25 0 0021 17.25V6.75',
            'video' => 'M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z',
        ];
    @endphp

    <section class="max-w-6xl mx-auto px-6 lg:px-8 py-8">

        <a href="{{ route('map') }}" class="inline-flex items-center gap-2 text-sm font-medium text-neutral-700 hover:text-green-700 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['arrow'] }}" />
            </svg>
            Kembali ke Peta
        </a>

        {{-- ============ FOTO + INFO RINGKAS ============ --}}
        <div class="grid grid-cols-1 lg:grid-cols-[1.4fr_1fr] gap-6">

            {{-- Kalau belum ada foto (media_rumah kosong), tampilkan placeholder rapi, bukan gambar rusak --}}
            <div class="rounded-2xl overflow-hidden h-72 lg:h-80 bg-green-900/5 border border-dashed border-green-900/20 relative">
                @if ($rumah->foto_utama)
                    <img
                        src="{{ $rumah->foto_utama }}"
                        alt="{{ $rumah->nama_tampil }}"
                        class="w-full h-full object-cover"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >
                @endif
                <div class="{{ $rumah->foto_utama ? 'hidden' : 'flex' }} absolute inset-0 items-center justify-center text-center px-6">
                    <p class="text-sm text-neutral-400">Belum ada foto untuk rumah ini</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-neutral-100 p-6">
                <h1 class="text-xl font-bold text-green-900 mb-1">{{ $rumah->nama_tampil }}</h1>
                <p class="text-xs text-neutral-400 mb-5">
                    @if ($rumah->nama_asli)
                        "{{ $rumah->nama_asli }}" &middot;
                    @endif
                    Jorong {{ $rumah->jorong_label }}
                </p>

                <dl class="space-y-4 text-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 shrink-0 rounded-lg bg-green-50 text-green-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['home'] }}" />
                            </svg>
                        </div>
                        <div class="flex-1 flex items-center justify-between">
                            <dt class="text-neutral-500">Status</dt>
                            <dd class="font-medium text-neutral-800 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full {{ $rumah->status_dot }} inline-block"></span>
                                {{ $rumah->status_label }}
                            </dd>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 shrink-0 rounded-lg bg-green-50 text-green-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['users'] }}" />
                            </svg>
                        </div>
                        <div class="flex-1 flex items-center justify-between">
                            <dt class="text-neutral-500">Suku</dt>
                            <dd class="font-medium text-neutral-800">{{ $rumah->suku_label }}</dd>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 shrink-0 rounded-lg bg-green-50 text-green-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['tag'] }}" />
                            </svg>
                        </div>
                        <div class="flex-1 flex items-center justify-between gap-3">
                            <dt class="text-neutral-500 shrink-0">Kategori</dt>
                            <dd class="font-medium text-neutral-800 text-right">{{ $rumah->kategori_label }}</dd>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 shrink-0 rounded-lg bg-green-50 text-green-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['pin'] }}" />
                            </svg>
                        </div>
                        <div class="flex-1 flex items-center justify-between gap-3">
                            <dt class="text-neutral-500 shrink-0">Alamat</dt>
                            <dd class="font-medium text-neutral-800 text-right">{{ $rumah->alamat_label }}</dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        {{-- ============ TABS ============ --}}
        <div class="bg-white rounded-2xl border border-neutral-100 mt-6">

            <div class="flex overflow-x-auto border-b border-neutral-100 px-2" role="tablist">
                @php
                    $tabs = [
                        'informasi' => ['label' => 'Informasi', 'icon' => 'info'],
                        'sejarah'   => ['label' => 'Sejarah',   'icon' => 'book'],
                        'galeri'    => ['label' => 'Galeri',    'icon' => 'photo'],
                        'video'     => ['label' => 'Video',     'icon' => 'video'],
                    ];
                @endphp

                @foreach ($tabs as $key => $tab)
                    <button
                        type="button"
                        data-tab-btn="{{ $key }}"
                        onclick="switchTab('{{ $key }}')"
                        class="tab-btn flex items-center gap-2 px-4 py-3.5 text-sm font-medium whitespace-nowrap border-b-2 transition-colors {{ $loop->first ? 'text-green-700 border-green-600' : 'text-neutral-500 border-transparent hover:text-green-700' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$tab['icon']] }}" />
                        </svg>
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>

            {{-- Tab: Informasi --}}
            <div data-tab-panel="informasi" class="tab-panel p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <dl class="text-sm divide-y divide-neutral-100">
                    @foreach ([
                        'Nama Rumah'       => $rumah->nama_tampil,
                        'Kategori'         => $rumah->kategori_label,
                        'Status'           => $rumah->status_label,
                        'Tahun Dibangun'   => $rumah->tahun_dibangun_label,
                        'Suku'             => $rumah->suku_label,
                        'Pemilik'          => $rumah->pemilik_label,
                        'Ninik Mamak'      => $rumah->ninik_mamak_label,
                        'Jumlah Penghuni'  => $rumah->jumlah_penghuni_label,
                        'Jumlah KK'        => $rumah->jumlah_kk_label,
                    ] as $label => $value)
                        <div class="flex justify-between gap-3 py-2.5">
                            <dt class="text-neutral-500">{{ $label }}</dt>
                            <dd class="font-medium text-neutral-800 text-right">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>

                <div>
                    <p class="font-semibold text-green-900 mb-3">Lokasi</p>

                    @if ($rumah->has_lokasi)
                        <div id="lokasi-map" class="rounded-xl h-56 w-full"></div>
                        <p class="text-xs text-neutral-500 mt-2">Koordinat: {{ $rumah->koordinat_label }}</p>
                    @else
                        <div class="rounded-xl h-56 w-full bg-green-900/5 border border-dashed border-green-900/20 flex items-center justify-center text-center px-6">
                            <p class="text-sm text-neutral-400">Titik koordinat rumah ini belum terdata di survei.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tab: Sejarah --}}
            <div data-tab-panel="sejarah" class="tab-panel hidden p-6">
                @php
                    $sejarahRaw = trim($rumah->sejarah_teks);

                    // Kalau admin sudah input per-paragraf (ada baris kosong), pakai itu.
                    $paragraphs = array_filter(array_map('trim', preg_split('/\r\n\r\n|\n\n/', $sejarahRaw)));

                    // Kalau ternyata cuma satu paragraf raksasa tanpa baris kosong sama
                    // sekali, pecah otomatis tiap ~3 kalimat biar tetap enak dibaca.
                    if (count($paragraphs) <= 1) {
                        $sentences = preg_split('/(?<=[.!?])\s+(?=[A-Z0-9])/', $sejarahRaw) ?: [$sejarahRaw];
                        $paragraphs = array_map(fn ($chunk) => implode(' ', $chunk), array_chunk($sentences, 3));
                    }
                @endphp

                <div class="relative">
                    <div
                        id="sejarah-content"
                        class="space-y-4 text-sm text-neutral-600 leading-relaxed [text-align:justify] max-h-[340px] overflow-hidden transition-[max-height] duration-500 ease-in-out"
                        data-expanded="false"
                    >
                        @foreach ($paragraphs as $p)
                            <p>{{ $p }}</p>
                        @endforeach
                    </div>

                    <div id="sejarah-fade" class="hidden absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
                </div>

                <button
                    id="sejarah-toggle"
                    type="button"
                    class="hidden mt-3 items-center gap-1 text-sm font-medium text-green-700 hover:underline"
                >
                    <span id="sejarah-toggle-label">Baca Selengkapnya</span>
                    <svg id="sejarah-toggle-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </div>
        

            {{-- Tab: Galeri --}}
            <div data-tab-panel="galeri" class="tab-panel hidden p-6">
                @if ($rumah->galeri_foto->isNotEmpty())
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach ($rumah->galeri_foto as $foto)
                            <div class="h-28 rounded-lg bg-green-900/5 border border-neutral-100 overflow-hidden">
                                <img
                                    src="{{ asset('storage/' . $foto->file) }}"
                                    alt="{{ $foto->nama_file ?? $rumah->nama_tampil }}"
                                    class="w-full h-full object-cover"
                                    onerror="this.parentElement.style.display='none'"
                                >
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="h-28 rounded-lg bg-green-900/5 border border-dashed border-green-900/20 flex items-center justify-center text-sm text-neutral-400">
                        Belum ada foto galeri untuk rumah ini
                    </div>
                @endif
            </div>

            {{-- Tab: Video --}}
            <div data-tab-panel="video" class="tab-panel hidden p-6">
                @if ($rumah->video_utama)
                    <video src="{{ $rumah->video_utama }}" controls class="w-full rounded-xl max-h-96"></video>
                @else
                    <div class="h-64 rounded-xl bg-green-900/5 border border-dashed border-green-900/20 flex items-center justify-center text-sm text-neutral-500">
                        Belum ada video untuk rumah ini
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // --- Tab switching (selalu aktif, terlepas dari ada/tidaknya lokasi) ---
    function switchTab(key) {
        document.querySelectorAll('.tab-panel').forEach(el => el.classList.add('hidden'));
        document.querySelector(`[data-tab-panel="${key}"]`).classList.remove('hidden');

        document.querySelectorAll('.tab-btn').forEach(btn => {
            const active = btn.dataset.tabBtn === key;
            btn.classList.toggle('text-green-700', active);
            btn.classList.toggle('border-green-600', active);
            btn.classList.toggle('text-neutral-500', !active);
            btn.classList.toggle('border-transparent', !active);
        });

        if (key === 'informasi' && typeof initLokasiMap === 'function') {
            initLokasiMap();
            setTimeout(() => window.lokasiMap && window.lokasiMap.invalidateSize(), 50);
        }

        if (key === 'sejarah') {
            checkSejarahOverflow();
        }
    }

    // --- Sejarah: auto "Baca Selengkapnya" kalau teksnya panjang ---
    function checkSejarahOverflow() {
        const content = document.getElementById('sejarah-content');
        const fade = document.getElementById('sejarah-fade');
        const toggle = document.getElementById('sejarah-toggle');
        if (!content || !fade || !toggle) return;

        if (content.dataset.expanded !== 'true') {
            content.style.maxHeight = '340px';
        }

        requestAnimationFrame(() => {
            const isOverflowing = content.scrollHeight > content.clientHeight + 4;

            if (isOverflowing) {
                toggle.classList.remove('hidden');
                toggle.classList.add('inline-flex');
                fade.classList.toggle('hidden', content.dataset.expanded === 'true');
            } else {
                toggle.classList.add('hidden');
                toggle.classList.remove('inline-flex');
                fade.classList.add('hidden');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('sejarah-toggle')?.addEventListener('click', function () {
            const content = document.getElementById('sejarah-content');
            const fade = document.getElementById('sejarah-fade');
            const label = document.getElementById('sejarah-toggle-label');
            const icon = document.getElementById('sejarah-toggle-icon');
            const expanded = content.dataset.expanded === 'true';

            if (expanded) {
                content.style.maxHeight = '340px';
                content.dataset.expanded = 'false';
                fade.classList.remove('hidden');
                label.textContent = 'Baca Selengkapnya';
                icon.style.transform = 'rotate(0deg)';
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
                content.dataset.expanded = 'true';
                fade.classList.add('hidden');
                label.textContent = 'Tampilkan Lebih Sedikit';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
</script>

@if ($rumah->has_lokasi)
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function initLokasiMap() {
            if (window.lokasiMap) return;

            window.lokasiMap = L.map('lokasi-map', {
                zoomControl: false,
                dragging: false,
                scrollWheelZoom: false,
            }).setView([{{ $rumah->latitude }}, {{ $rumah->longitude }}], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(window.lokasiMap);

            L.marker([{{ $rumah->latitude }}, {{ $rumah->longitude }}]).addTo(window.lokasiMap);
        }

        document.addEventListener('DOMContentLoaded', initLokasiMap);
    </script>
@endif
@endpush