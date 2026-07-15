@extends('layouts.app')

@section('title', 'Peta — WebGIS Kampung Adat Sijunjung')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        #leaflet-map { background: #e9ede9; }
        .leaflet-popup-content-wrapper { border-radius: 14px; padding: 0; overflow: hidden; }
        .leaflet-popup-content { margin: 0; width: 260px !important; }
        .marker-pin {
            width: 34px; height: 34px; border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg); display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,.35); border: 2px solid white;
        }
        .marker-pin svg { transform: rotate(45deg); width: 16px; height: 16px; }
        .marker-dihuni   { background: #16a34a; }
        .marker-kosong   { background: #f97316; }
        .marker-fasilitas{ background: #2563eb; }
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
            Jelajahi lokasi rumah adat dan fasilitas di Kampung Adat Sijunjung secara interaktif.
        </p>
    </section>

    <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-20 grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6">

        {{-- Sidebar filter --}}
        <aside class="bg-white rounded-2xl border border-neutral-100 p-5 h-fit lg:sticky lg:top-24">
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
                        <span class="w-2 h-2 rounded-full bg-green-600 inline-block"></span> Masih Dihuni
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
            </div>

            {{-- Suku --}}
            <div class="mb-5">
                <p class="text-sm font-medium text-neutral-800 mb-2">Suku</p>
                <div class="space-y-2 text-sm text-neutral-600">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="filter-suku" value="" checked class="accent-green-600"> Semua
                    </label>
                    @foreach ($sukuList as $suku)
                        <label class="flex items-center gap-2">
                            <input type="radio" name="filter-suku" value="{{ $suku }}" class="accent-green-600"> {{ $suku }}
                        </label>
                    @endforeach
                </div>
            </div>

            <button
                type="button"
                id="reset-filter"
                class="w-full text-sm font-medium text-neutral-600 border border-neutral-200 rounded-lg py-2 hover:bg-neutral-50"
            >
                ↺ Reset Filter
            </button>
        </aside>

        {{-- Map --}}
        <div class="relative">
            <div class="absolute top-4 left-1/2 -translate-x-1/2 z-[1000] w-[92%] max-w-md">
                <div class="relative">
                    <input
                        type="text"
                        id="map-search"
                        placeholder="Cari nama rumah, suku, atau fasilitas..."
                        class="w-full text-sm rounded-xl border border-neutral-200 bg-white shadow-md pl-4 pr-10 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 absolute right-3.5 top-1/2 -translate-y-1/2 text-neutral-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
            </div>

            <div id="leaflet-map" class="rounded-2xl h-[70vh] min-h-[420px] w-full"></div>
        </div>
    </section>

    {{-- Template popup (dipakai lewat JS, tidak dirender langsung) --}}
    <template id="popup-template">
        <div>
            <div class="w-full h-32 bg-green-900/10 overflow-hidden">
                <img data-role="foto" src="" alt="" class="w-full h-full object-cover" onerror="this.style.display='none'">
            </div>
            <div class="p-3">
                <p data-role="nama" class="font-semibold text-green-900 text-sm"></p>
                <p class="text-xs text-neutral-600 mt-1"><span data-role="suku-row"></span></p>
                <p class="text-xs text-neutral-600"><span data-role="status-row"></span></p>
                <p class="text-xs text-neutral-600"><span data-role="kategori-row"></span></p>
                <a data-role="link" href="#" class="inline-block mt-3 text-xs font-medium text-white bg-green-600 hover:bg-green-500 rounded-lg px-3 py-1.5">
                    Lihat Detail
                </a>
            </div>
        </div>
    </template>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const map = L.map('leaflet-map', { zoomControl: false }).setView([-0.6365, 100.8100], 15);
    L.control.zoom({ position: 'topright' }).addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    const markersLayer = L.layerGroup().addTo(map);

    function pinIcon(kind) {
        // kind: 'dihuni' | 'kosong' | 'fasilitas'
        const cls = kind === 'fasilitas' ? 'marker-fasilitas' : (kind === 'kosong' ? 'marker-kosong' : 'marker-dihuni');
        const homeSvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconHome }}"/></svg>';
        const bldSvg  = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconBuilding }}"/></svg>';
        return L.divIcon({
            className: '',
            html: `<div class="marker-pin ${cls}">${kind === 'fasilitas' ? bldSvg : homeSvg}</div>`,
            iconSize: [34, 34],
            iconAnchor: [17, 34],
            popupAnchor: [0, -32],
        });
    }

    function buildPopup(item, type) {
        const tpl = document.getElementById('popup-template').content.cloneNode(true);
        const wrap = document.createElement('div');
        wrap.appendChild(tpl);

        wrap.querySelector('[data-role="foto"]').src = item.foto || '';
        wrap.querySelector('[data-role="foto"]').alt = item.nama;
        wrap.querySelector('[data-role="nama"]').textContent = item.nama;

        if (type === 'rumah') {
            wrap.querySelector('[data-role="suku-row"]').textContent = 'Suku: ' + item.suku;
            wrap.querySelector('[data-role="status-row"]').textContent =
                'Status: ' + (item.status === 'dihuni' ? 'Masih Dihuni' : 'Kosong');
            wrap.querySelector('[data-role="kategori-row"]').textContent = 'Kategori: ' + item.kategori;
            wrap.querySelector('[data-role="link"]').href = `/rumah/${item.id}`;
        } else {
            wrap.querySelector('[data-role="suku-row"]').textContent = 'Kategori: ' + item.kategori;
            wrap.querySelector('[data-role="status-row"]').remove();
            wrap.querySelector('[data-role="kategori-row"]').remove();
            wrap.querySelector('[data-role="link"]').remove();
        }

        return wrap.innerHTML;
    }

    function render(data) {
        markersLayer.clearLayers();

        const showRumah = document.getElementById('filter-rumah').checked;
        const showFasilitas = document.getElementById('filter-fasilitas').checked;

        if (showRumah) {
            data.rumah_adat.forEach(item => {
                L.marker([item.lat, item.lng], { icon: pinIcon(item.status) })
                    .bindPopup(buildPopup(item, 'rumah'))
                    .addTo(markersLayer);
            });
        }

        if (showFasilitas) {
            data.fasilitas.forEach(item => {
                L.marker([item.lat, item.lng], { icon: pinIcon('fasilitas') })
                    .bindPopup(buildPopup(item, 'fasilitas'))
                    .addTo(markersLayer);
            });
        }
    }

    function fetchAndRender() {
        const status = document.querySelector('input[name="status-rumah"]:checked')?.value || '';
        const suku = document.querySelector('input[name="filter-suku"]:checked')?.value || '';
        const search = document.getElementById('map-search').value || '';

        const params = new URLSearchParams();
        if (status) params.set('status', status);
        if (suku) params.set('suku', suku);
        if (search) params.set('search', search);

        fetch(`{{ route('map.data') }}?${params.toString()}`)
            .then(res => res.json())
            .then(render)
            .catch(err => console.error('Gagal memuat data peta:', err));
    }

    // Event listeners
    document.getElementById('filter-rumah').addEventListener('change', fetchAndRender);
    document.getElementById('filter-fasilitas').addEventListener('change', fetchAndRender);
    document.querySelectorAll('input[name="status-rumah"]').forEach(el => el.addEventListener('change', fetchAndRender));
    document.querySelectorAll('input[name="filter-suku"]').forEach(el => el.addEventListener('change', fetchAndRender));

    let searchTimer;
    document.getElementById('map-search').addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(fetchAndRender, 300);
    });

    document.getElementById('reset-filter').addEventListener('click', function () {
        document.getElementById('filter-rumah').checked = true;
        document.getElementById('filter-fasilitas').checked = true;
        document.querySelector('input[name="status-rumah"][value=""]').checked = true;
        document.querySelector('input[name="filter-suku"][value=""]').checked = true;
        document.getElementById('map-search').value = '';
        fetchAndRender();
    });

    // Initial load
    fetchAndRender();
});
</script>
@endpush 