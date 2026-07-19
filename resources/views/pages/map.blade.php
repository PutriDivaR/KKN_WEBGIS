@extends('layouts.app')

@section('title', 'Peta — WebGIS Kampung Adat Sijunjung')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        #leaflet-map { background: #e9ede9; }

        /* ---------- Popup ---------- */
        .leaflet-popup-content-wrapper {
            border-radius: 16px; padding: 0; overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 40, 25, .18);
        }
        .leaflet-popup-content { margin: 0; width: 272px !important; }
        .leaflet-popup-tip { box-shadow: 0 6px 14px rgba(15, 40, 25, .12); }
        .leaflet-popup-close-button {
            color: white !important; top: 8px !important; right: 8px !important;
            width: 22px !important; height: 22px !important; border-radius: 9999px;
            background: rgba(0,0,0,.35); font-size: 15px !important; line-height: 20px !important;
        }
        .leaflet-popup-close-button:hover { background: rgba(0,0,0,.55); }

        .popup-media { position: relative; height: 132px; overflow: hidden; background: #eef2ee; }
        .popup-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s ease; }
        .leaflet-popup:hover .popup-media img { transform: scale(1.06); }
        .popup-media-fallback {
            width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #e7efe9, #d8e6dc); color: #2f4a37;
        }

        .popup-badge {
            position: absolute; top: 10px; left: 10px; font-size: 10.5px; font-weight: 600;
            letter-spacing: .01em; color: white; padding: 3px 9px; border-radius: 9999px;
            box-shadow: 0 1px 4px rgba(0,0,0,.25); text-transform: uppercase;
        }
        .popup-badge-dihuni  { background: #16a34a; }
        .popup-badge-kosong  { background: #f97316; }
        .popup-badge-unknown { background: #737373; }
        .popup-badge-fasilitas { background: #0d9488; }

        .popup-body { padding: 13px 15px 15px; }
        .popup-title { font-weight: 700; color: #14532d; font-size: 14px; line-height: 1.3; }
        .popup-meta { margin-top: 6px; font-size: 12px; color: #57534e; line-height: 1.55; }
        .popup-meta strong { color: #3f3f3f; font-weight: 600; }
        .popup-desc { margin-top: 6px; font-size: 12px; color: #57534e; line-height: 1.55; }

        .popup-btn {
            display: inline-flex; align-items: center; gap: 5px; margin-top: 12px;
            font-size: 12.5px; font-weight: 600; color: white; border: none; cursor: pointer;
            border-radius: 9999px; padding: 7px 14px; box-shadow: 0 2px 6px rgba(0,0,0,.15);
            transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease;
        }
        .popup-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(0,0,0,.2); }
        .popup-btn svg { width: 13px; height: 13px; transition: transform .15s ease; }
        .popup-btn:hover svg { transform: translateX(2px); }
        .popup-btn-green { background: #16a34a; }
        .popup-btn-green:hover { background: #15803d; }
        .popup-btn-teal { background: #0d9488; }
        .popup-btn-teal:hover { background: #0f766e; }

        /* ---------- Marker pin ---------- */
        .marker-pin {
            width: 34px; height: 34px; border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg); display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,.35); border: 2px solid white;
        }
        .marker-pin svg { transform: rotate(45deg); width: 16px; height: 16px; }

        /* Rumah adat */
        .marker-dihuni   { background: #16a34a; }
        .marker-kosong   { background: #f97316; }
        .marker-unknown  { background: #737373; }

        /* Fasilitas — dibedakan per kategori */
        .marker-fasilitas-pendidikan       { background: #2563eb; }
        .marker-fasilitas-pusat-informasi  { background: #9333ea; }
        .marker-fasilitas-umum             { background: #0d9488; }
    </style>
@endpush

@section('content')

    @php
        $iconHome = 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25';
        $iconBuilding = 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21';
    @endphp

    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <h1 class="text-2xl md:text-3xl font-bold text-green-900">Peta Interaktif</h1>
        <p class="mt-2 text-neutral-600 max-w-2xl">
            Jelajahi lokasi rumah adat dan fasilitas di Kampung Adat Sijunjung secara interaktif, berdasarkan data hasil survei lapangan.
        </p>
    </section>

    <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-20 grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6">

        {{-- Sidebar filter --}}
        <aside class="bg-white rounded-2xl border border-neutral-200 shadow-sm p-5 sticky top-24 h-fit">
            <div class="max-h-[65vh] overflow-y-auto pr-2">
            <p class="font-semibold text-green-900 mb-4 tracking-wide text-sm">LAYER PETA</p>

            {{-- Rumah Adat --}}
            <div class="mb-5">
                <label class="flex items-center gap-2 text-sm font-medium text-neutral-800">
                    <input type="checkbox" id="filter-rumah" checked class="accent-green-600 rounded">
                    Rumah Adat
                </label>
                <div id="filter-rumah-sub" class="ml-6 mt-2 space-y-2 text-sm text-neutral-600">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="status-rumah" value="" checked class="accent-green-600"> Semua
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="status-rumah" value="dihuni" class="accent-green-600">
                        <span class="w-2 h-2 rounded-full bg-green-600 inline-block"></span> Aktif Dihuni
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="status-rumah" value="kosong" class="accent-green-600">
                        <span class="w-2 h-2 rounded-full bg-orange-500 inline-block"></span> Kosong
                    </label>
                </div>
            </div>

            {{-- Fasilitas --}}
            <div class="mb-5">
                <label class="flex items-center gap-2 text-sm font-medium text-neutral-800">
                    <input type="checkbox" id="filter-fasilitas" checked class="accent-green-600 rounded">
                    Fasilitas
                </label>
                <div id="filter-fasilitas-sub" class="ml-6 mt-2 space-y-2 text-sm text-neutral-600">
                    @foreach ($kategoriFasilitasList as $kategori)
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="filter-kategori-fasilitas" value="{{ $kategori }}" class="accent-green-600 rounded kategori-fasilitas-checkbox">
                            {{ $kategori }}
                        </label>
                    @endforeach
                </div>
                <p class="ml-6 mt-1.5 text-xs text-neutral-400">Kosongkan semua centang = tampilkan semua kategori.</p>
            </div>

            {{-- Suku — checkbox, bisa pilih lebih dari satu --}}
            <div class="mb-5">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-neutral-800">Suku</p>
                    <button type="button" id="suku-semua" class="text-xs font-medium text-green-700 hover:underline">Semua</button>
                </div>
                <div class="space-y-2 text-sm text-neutral-600 max-h-64 overflow-y-auto pr-1">
                    @foreach ($sukuList as $suku)
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="filter-suku" value="{{ $suku->id_suku }}" class="accent-green-600 rounded suku-checkbox">
                            {{ $suku->nama_suku }}
                        </label>
                    @endforeach
                </div>
                <p class="mt-1.5 text-xs text-neutral-400">Kosongkan semua centang = tampilkan semua suku.</p>
            </div>

            <button
                type="button"
                id="reset-filter"
                class="w-full text-sm font-medium text-neutral-600 border border-neutral-200 rounded-lg py-2 hover:bg-neutral-50"
            >
                ↺ Reset Filter
            </button>

            {{-- Legenda singkat --}}
            <div class="mt-6 pt-5 border-t border-neutral-100">
                <p class="font-semibold text-green-900 mb-3 tracking-wide text-sm">LEGENDA</p>
                <div class="space-y-1.5 text-xs text-neutral-600">
                    <p class="text-[11px] font-medium text-neutral-400 uppercase tracking-wide mt-1 mb-1">Rumah Adat</p>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-600 inline-block shrink-0"></span> Aktif Dihuni
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-orange-500 inline-block shrink-0"></span> Kosong
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-neutral-500 inline-block shrink-0"></span> Belum Diketahui
                    </div>

                    <p class="text-[11px] font-medium text-neutral-400 uppercase tracking-wide mt-3 mb-1">Fasilitas</p>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block shrink-0"></span> Pendidikan
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-600 inline-block shrink-0"></span> Pusat Informasi
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-teal-600 inline-block shrink-0"></span> Umum
                    </div>
                </div>
            </div>
        </div>
        </aside>

        {{-- Map --}}
        <div class="relative">
            <div class="absolute top-4 left-1/2 -translate-x-1/2 z-[1000] w-[92%] max-w-md">
                <div class="relative">
                    <input
                        type="text"
                        id="map-search"
                        placeholder="Cari nama/nomor rumah, suku, atau fasilitas..."
                        class="w-full text-sm rounded-xl border border-neutral-200 bg-white shadow-md pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 absolute right-3.5 top-1/2 -translate-y-1/2 text-neutral-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
            </div>

            <div id="leaflet-map" class="rounded-2xl h-[70vh] min-h-[420px] w-full"></div>

            <p id="map-empty-note" class="hidden mt-3 text-sm text-neutral-500 bg-neutral-50 border border-neutral-100 rounded-xl px-4 py-3">
                Tidak ada titik yang cocok dengan filter ini.
            </p>
        </div>
    </section>

    {{-- Template popup rumah adat (dipakai lewat JS, tidak dirender langsung) --}}
    <template id="popup-template-rumah">
        <div>
            <div class="popup-media">
                <img data-role="foto" src="" alt="" onerror="this.remove(); this.closest('.popup-media').querySelector('[data-role=foto-fallback]').classList.remove('hidden')">
                <div data-role="foto-fallback" class="popup-media-fallback hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 opacity-60">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </div>
                <span data-role="status-badge" class="popup-badge"></span>
            </div>
            <div class="popup-body">
                <p data-role="nama" class="popup-title"></p>
                <p class="popup-meta"><strong>Suku:</strong> <span data-role="suku-row"></span></p>
                <p class="popup-meta"><strong>Kategori:</strong> <span data-role="kategori-row"></span></p>
                <a data-role="link" href="#" class="popup-btn popup-btn-green">
                    Lihat Detail
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </template>

    {{-- Template popup fasilitas --}}
    <template id="popup-template-fasilitas">
        <div>
            <div class="popup-media">
                <img data-role="foto" src="" alt="" onerror="this.remove(); this.closest('.popup-media').querySelector('[data-role=foto-fallback]').classList.remove('hidden')">
                <div data-role="foto-fallback" class="popup-media-fallback hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 opacity-60">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <span data-role="kategori-badge" class="popup-badge popup-badge-fasilitas"></span>
            </div>
            <div class="popup-body">
                <p data-role="nama" class="popup-title"></p>
                <p data-role="deskripsi" class="popup-desc"></p>
                <button type="button" data-role="link" data-id="" class="popup-btn popup-btn-teal">
                    Lihat Detail
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </button>
            </div>
        </div>
    </template>

    {{-- ============ MODAL DETAIL FASILITAS (dibuka dari popup marker) ============ --}}
    <div
        id="fasilitasDetailModal"
        class="hidden fixed inset-0 z-[1100] bg-black/70 items-center justify-center p-4"
        onclick="closeFasilitasDetailBackdrop(event)"
    >
        <div class="relative bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">

            <button
                type="button"
                onclick="closeFasilitasDetail()"
                class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white shadow flex items-center justify-center text-neutral-500 hover:text-green-800"
                aria-label="Tutup"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-2">

                {{-- Media: foto/video utama + thumbnail --}}
                <div class="bg-neutral-900 md:rounded-l-2xl flex flex-col">
                    <div id="faskDetailMainMedia" class="h-64 md:h-full min-h-[18rem] flex items-center justify-center overflow-hidden bg-neutral-900"></div>
                    <div id="faskDetailThumbs" class="flex gap-2 overflow-x-auto p-3 bg-black/40 [&::-webkit-scrollbar]:hidden"></div>
                </div>

                {{-- Deskripsi --}}
                <div class="p-6">
                    <div class="flex flex-wrap gap-1.5">
                        <span id="faskDetailKategori" class="inline-block text-xs font-medium text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full"></span>
                        <span id="faskDetailJorong" class="hidden text-xs font-medium text-neutral-500 bg-neutral-100 px-2.5 py-1 rounded-full"></span>
                    </div>

                    <h2 id="faskDetailNama" class="text-xl font-bold text-green-900 mt-3"></h2>
                    <p id="faskDetailDeskripsi" class="text-sm text-neutral-600 mt-3 leading-relaxed whitespace-pre-line"></p>

                    <a
                        id="faskDetailMapLink"
                        href="#"
                        target="_blank"
                        rel="noopener"
                        class="hidden inline-flex items-center gap-1.5 mt-6 text-sm text-teal-700 font-medium hover:underline"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        Buka Lokasi di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const DATA_URL = @json(route('map.data'));
    const RUMAH_BASE_URL = @json(url('/rumah'));
    const ICON_HOME = '{{ $iconHome }}';
    const ICON_BUILDING = '{{ $iconBuilding }}';

    const map = L.map('leaflet-map', { zoomControl: false }).setView([-0.708, 100.9855], 15);
    L.control.zoom({ position: 'topright' }).addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    const markersLayer = L.layerGroup().addTo(map);
    let hasFittedOnce = false;

    // ---------- Icon rumah adat ----------
    function pinIconRumah(status) {
        const cls = status === 'dihuni' ? 'marker-dihuni' : (status === 'kosong' ? 'marker-kosong' : 'marker-unknown');
        const homeSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white"><path stroke-linecap="round" stroke-linejoin="round" d="${ICON_HOME}"/></svg>`;
        return L.divIcon({
            className: '',
            html: `<div class="marker-pin ${cls}">${homeSvg}</div>`,
            iconSize: [34, 34],
            iconAnchor: [17, 34],
            popupAnchor: [0, -32],
        });
    }

    // ---------- Icon fasilitas (dibedakan per kategori) ----------
    function kategoriToClass(kategori) {
        const key = (kategori || 'umum').toLowerCase().replace(/\s+/g, '-');
        if (key === 'pendidikan') return 'marker-fasilitas-pendidikan';
        if (key === 'pusat-informasi') return 'marker-fasilitas-pusat-informasi';
        return 'marker-fasilitas-umum';
    }

    function pinIconFasilitas(kategori) {
        const cls = kategoriToClass(kategori);
        const buildingSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white"><path stroke-linecap="round" stroke-linejoin="round" d="${ICON_BUILDING}"/></svg>`;
        return L.divIcon({
            className: '',
            html: `<div class="marker-pin ${cls}">${buildingSvg}</div>`,
            iconSize: [34, 34],
            iconAnchor: [17, 34],
            popupAnchor: [0, -32],
        });
    }

    function buildPopupRumah(item) {
        const tpl = document.getElementById('popup-template-rumah').content.cloneNode(true);
        const wrap = document.createElement('div');
        wrap.appendChild(tpl);

        const fotoEl = wrap.querySelector('[data-role="foto"]');
        if (item.foto) {
            fotoEl.src = item.foto;
            fotoEl.alt = item.nama;
        } else {
            fotoEl.remove();
            wrap.querySelector('[data-role="foto-fallback"]').classList.remove('hidden');
        }

        const statusText = item.status === 'dihuni' ? 'Aktif Dihuni' : (item.status === 'kosong' ? 'Kosong' : 'Belum Diketahui');
        const badgeCls = item.status === 'dihuni' ? 'popup-badge-dihuni' : (item.status === 'kosong' ? 'popup-badge-kosong' : 'popup-badge-unknown');
        const badgeEl = wrap.querySelector('[data-role="status-badge"]');
        badgeEl.textContent = statusText;
        badgeEl.classList.add(badgeCls);

        wrap.querySelector('[data-role="nama"]').textContent = item.nama;
        wrap.querySelector('[data-role="suku-row"]').textContent = item.suku || 'Belum diketahui';
        wrap.querySelector('[data-role="kategori-row"]').textContent = item.kategori || 'Belum dikategorikan';
        wrap.querySelector('[data-role="link"]').href = `${RUMAH_BASE_URL}/${item.id}`;

        return wrap.innerHTML;
    }

    function buildPopupFasilitas(item) {
        const tpl = document.getElementById('popup-template-fasilitas').content.cloneNode(true);
        const wrap = document.createElement('div');
        wrap.appendChild(tpl);

        const fotoEl = wrap.querySelector('[data-role="foto"]');
        if (item.foto) {
            fotoEl.src = item.foto;
            fotoEl.alt = item.nama;
        } else {
            fotoEl.remove();
            wrap.querySelector('[data-role="foto-fallback"]').classList.remove('hidden');
        }

        wrap.querySelector('[data-role="kategori-badge"]').textContent = item.kategori || 'Umum';
        wrap.querySelector('[data-role="nama"]').textContent = item.nama;

        const deskripsi = item.deskripsi && item.deskripsi.trim() !== ''
            ? (item.deskripsi.length > 100 ? item.deskripsi.slice(0, 100) + '…' : item.deskripsi)
            : 'Belum ada deskripsi untuk fasilitas ini.';
        wrap.querySelector('[data-role="deskripsi"]').textContent = deskripsi;

        // Tombol ini tidak menavigasi ke halaman lain — id-nya dipakai
        // oleh listener popupopen di bawah untuk membuka modal detail.
        wrap.querySelector('[data-role="link"]').dataset.id = item.id;

        return wrap.innerHTML;
    }

    // Simpan data fasilitas per id supaya modal detail bisa diisi tanpa fetch ulang.
    let fasilitasById = {};

    function render(data) {
        markersLayer.clearLayers();

        const showRumah = document.getElementById('filter-rumah').checked;
        const showFasilitas = document.getElementById('filter-fasilitas').checked;

        const rumahList = showRumah ? (data.rumah_adat || []) : [];
        const fasilitasList = showFasilitas ? (data.fasilitas || []) : [];

        fasilitasById = {};
        fasilitasList.forEach(item => { fasilitasById[item.id] = item; });

        rumahList.forEach(item => {
            L.marker([item.lat, item.lng], { icon: pinIconRumah(item.status) })
                .bindPopup(buildPopupRumah(item))
                .addTo(markersLayer);
        });

        fasilitasList.forEach(item => {
            L.marker([item.lat, item.lng], { icon: pinIconFasilitas(item.kategori) })
                .bindPopup(buildPopupFasilitas(item))
                .addTo(markersLayer);
        });

        const allPoints = [...rumahList, ...fasilitasList];

        const emptyNote = document.getElementById('map-empty-note');
        emptyNote.classList.toggle('hidden', allPoints.length > 0);

        // Otomatis arahkan peta ke area marker-marker yang ada, bukan diam
        // di titik tetap (jadi tidak "nyasar" ke tanah kosong).
        if (allPoints.length > 0) {
            const bounds = L.latLngBounds(allPoints.map(i => [i.lat, i.lng]));
            map.fitBounds(bounds, { padding: [50, 50], maxZoom: 18 });
            hasFittedOnce = true;
        } else if (!hasFittedOnce) {
            map.setView([-0.708, 100.9855], 15);
        }
    }

    function fetchAndRender() {
        const status = document.querySelector('input[name="status-rumah"]:checked')?.value || '';
        const sukuIds = Array.from(document.querySelectorAll('.suku-checkbox:checked')).map(el => el.value);
        const kategoriFasilitas = Array.from(document.querySelectorAll('.kategori-fasilitas-checkbox:checked')).map(el => el.value);
        const search = document.getElementById('map-search').value || '';

        const params = new URLSearchParams();
        if (status) params.set('status', status);
        sukuIds.forEach(id => params.append('suku[]', id));
        kategoriFasilitas.forEach(k => params.append('kategori_fasilitas[]', k));
        if (search) params.set('search', search);

        fetch(`${DATA_URL}?${params.toString()}`)
            .then(res => res.json())
            .then(render)
            .catch(err => console.error('Gagal memuat data peta:', err));
    }

    // Tombol "Lihat Detail" pada popup fasilitas membuka modal, bukan pindah halaman.
    map.on('popupopen', function (e) {
        const popupEl = e.popup.getElement();
        const btn = popupEl.querySelector('[data-role="link"][data-id]');
        if (btn) {
            btn.addEventListener('click', function () {
                openFasilitasDetail(btn.dataset.id);
            });
        }
    });

    // ---------- Modal detail fasilitas ----------
    let faskDetailMedia = [];

    function openFasilitasDetail(id) {
        const item = fasilitasById[id];
        if (!item) return;

        map.closePopup();

        document.getElementById('faskDetailNama').textContent = item.nama;
        document.getElementById('faskDetailKategori').textContent = item.kategori || 'Umum';
        document.getElementById('faskDetailDeskripsi').textContent =
            item.deskripsi && item.deskripsi.trim() !== ''
                ? item.deskripsi
                : 'Belum ada deskripsi untuk fasilitas ini.';

        const jorongEl = document.getElementById('faskDetailJorong');
        if (item.jorong) {
            jorongEl.textContent = 'Jorong ' + item.jorong;
            jorongEl.classList.remove('hidden');
        } else {
            jorongEl.classList.add('hidden');
        }

        const mapLink = document.getElementById('faskDetailMapLink');
        if (item.lat && item.lng) {
            mapLink.href = `https://www.google.com/maps?q=${item.lat},${item.lng}`;
            mapLink.classList.remove('hidden');
        } else {
            mapLink.classList.add('hidden');
        }

        faskDetailMedia = Array.isArray(item.media) ? item.media : [];
        renderFaskDetailThumbs();

        if (faskDetailMedia.length) {
            showFaskDetailMedia(0);
        } else {
            document.getElementById('faskDetailMainMedia').innerHTML =
                `<img src="https://placehold.co/600x450/0d9488/e8efe9?text=${encodeURIComponent(item.nama)}" class="w-full h-full object-cover">`;
        }

        const modal = document.getElementById('fasilitasDetailModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function renderFaskDetailThumbs() {
        const wrap = document.getElementById('faskDetailThumbs');
        wrap.innerHTML = '';

        if (faskDetailMedia.length <= 1) return;

        faskDetailMedia.forEach((m, i) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.title = m.nama || '';
            btn.className = 'shrink-0 w-16 h-12 rounded-md overflow-hidden border-2 border-transparent hover:border-teal-400 transition';
            btn.onclick = () => showFaskDetailMedia(i);

            if (m.jenis === 'video') {
                btn.innerHTML = `
                    <div class="w-full h-full bg-neutral-700 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" class="w-4 h-4">
                            <path d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.972l-11.54 6.348a1.125 1.125 0 01-1.667-.986V5.653z" />
                        </svg>
                    </div>`;
            } else {
                btn.innerHTML = `<img src="${m.url}" class="w-full h-full object-cover" onerror="this.style.opacity='0.3'">`;
            }

            wrap.appendChild(btn);
        });
    }

    function showFaskDetailMedia(i) {
        const m = faskDetailMedia[i];
        const box = document.getElementById('faskDetailMainMedia');
        if (!m) return;

        if (m.jenis === 'video') {
            box.innerHTML = `<video src="${m.url}" class="w-full h-full object-contain" controls autoplay></video>`;
        } else {
            box.innerHTML = `<img src="${m.url}" alt="${m.nama || ''}" class="w-full h-full object-contain">`;
        }
    }

    // Di-expose ke window karena dipanggil lewat onclick="" inline pada
    // markup modal yang berada di luar closure DOMContentLoaded ini.
    window.closeFasilitasDetail = function () {
        const modal = document.getElementById('fasilitasDetailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('faskDetailMainMedia').innerHTML = '';
        document.body.style.overflow = '';
    };

    window.closeFasilitasDetailBackdrop = function (event) {
        if (event.target.id === 'fasilitasDetailModal') {
            window.closeFasilitasDetail();
        }
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeFasilitasDetail();
    });

    // --- Event listeners ---
    document.getElementById('filter-rumah').addEventListener('change', fetchAndRender);
    document.querySelectorAll('input[name="status-rumah"]').forEach(el => el.addEventListener('change', fetchAndRender));

    document.getElementById('filter-fasilitas').addEventListener('change', fetchAndRender);
    document.querySelectorAll('.kategori-fasilitas-checkbox').forEach(el => el.addEventListener('change', fetchAndRender));

    document.querySelectorAll('.suku-checkbox').forEach(el => {
        el.addEventListener('change', fetchAndRender);
    });

    document.getElementById('suku-semua').addEventListener('click', function () {
        document.querySelectorAll('.suku-checkbox').forEach(el => { el.checked = false; });
        fetchAndRender();
    });

    let searchTimer;
    document.getElementById('map-search').addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(fetchAndRender, 300);
    });

    document.getElementById('reset-filter').addEventListener('click', function () {
        document.getElementById('filter-rumah').checked = true;
        document.querySelector('input[name="status-rumah"][value=""]').checked = true;
        document.getElementById('filter-fasilitas').checked = true;
        document.querySelectorAll('.kategori-fasilitas-checkbox').forEach(el => { el.checked = false; });
        document.querySelectorAll('.suku-checkbox').forEach(el => { el.checked = false; });
        document.getElementById('map-search').value = '';
        fetchAndRender();
    });

    // Muat data pertama kali
    fetchAndRender();
});
</script>
@endpush