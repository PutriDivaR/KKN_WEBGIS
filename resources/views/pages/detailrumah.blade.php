@extends('layouts.app')

@section('title', $rumah['nama'] . ' — WebGIS Kampung Adat Sijunjung')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>#lokasi-map { background: #e9ede9; }</style>
@endpush

@section('content')

    @php
        $icons = [
            'home'     => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
            'users'    => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
            'tag'      => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.31a10.452 10.452 0 003.233-3.233c.562-.827.39-1.908-.31-2.607L9.19 3.66A2.25 2.25 0 007.6 3H9.568zM6 6h.008v.008H6V6z',
            'pin'      => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z',
            'arrow'    => 'M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18',
            'info'     => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
            'book'     => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
            'column'   => 'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z',
            'photo'    => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 6.75h18M3 6.75A2.25 2.25 0 015.25 4.5h13.5A2.25 2.25 0 0121 6.75m-18 0v10.5A2.25 2.25 0 005.25 19.5h13.5A2.25 2.25 0 0021 17.25V6.75',
            'video'    => 'M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z',
        ];

        $statusLabel = $rumah['status'] === 'dihuni' ? 'Masih Dihuni' : 'Kosong';
        $statusDot   = $rumah['status'] === 'dihuni' ? 'bg-green-600' : 'bg-orange-500';
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

            {{-- TEMPAT FILE FOTO UTAMA --}}
            <div class="rounded-2xl overflow-hidden h-72 lg:h-80 bg-green-900/5 border border-dashed border-green-900/20">
                <img
                    src="{{ $rumah['foto'] }}"
                    alt="{{ $rumah['nama'] }}"
                    class="w-full h-full object-cover"
                    onerror="this.style.display='none'"
                >
            </div>

            <div class="bg-white rounded-2xl border border-neutral-100 p-6">
                <h1 class="text-xl font-bold text-green-900 mb-5">{{ $rumah['nama'] }}</h1>

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
                                <span class="w-2 h-2 rounded-full {{ $statusDot }} inline-block"></span>
                                {{ $statusLabel }}
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
                            <dd class="font-medium text-neutral-800">{{ $rumah['suku'] }}</dd>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 shrink-0 rounded-lg bg-green-50 text-green-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['tag'] }}" />
                            </svg>
                        </div>
                        <div class="flex-1 flex items-center justify-between">
                            <dt class="text-neutral-500">Kategori</dt>
                            <dd class="font-medium text-neutral-800">{{ $rumah['kategori'] }}</dd>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 shrink-0 rounded-lg bg-green-50 text-green-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['pin'] }}" />
                            </svg>
                        </div>
                        <div class="flex-1 flex items-center justify-between">
                            <dt class="text-neutral-500">Alamat</dt>
                            <dd class="font-medium text-neutral-800 text-right">{{ $rumah['alamat'] }}</dd>
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
                        'informasi'  => ['label' => 'Informasi',  'icon' => 'info'],
                        'sejarah'    => ['label' => 'Sejarah',    'icon' => 'book'],
                        'galeri'     => ['label' => 'Galeri',     'icon' => 'photo'],
                        'video'      => ['label' => 'Video',      'icon' => 'video'],
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
                        'Nama Rumah'       => $rumah['nama'],
                        'Kategori'         => $rumah['kategori'],
                        'Status'           => $statusLabel,
                        'Tahun Dibangun'   => $rumah['tahun_dibangun'],
                        'Suku'             => $rumah['suku'],
                        'Pemilik'          => $rumah['pemilik'],
                        'Ninik Mamak'      => $rumah['ninik_mamak'],
                        'Jumlah Penghuni'  => $rumah['jumlah_penghuni'],
                        'Jumlah KK'        => $rumah['jumlah_kk'],
                    ] as $label => $value)
                        <div class="flex justify-between py-2.5">
                            <dt class="text-neutral-500">{{ $label }}</dt>
                            <dd class="font-medium text-neutral-800">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>

                <div>
                    <p class="font-semibold text-green-900 mb-3">Lokasi</p>
                    <div id="lokasi-map" class="rounded-xl h-56 w-full"></div>
                    <p class="text-xs text-neutral-500 mt-2">Koordinat: {{ $rumah['koordinat'] }}</p>
                </div>
            </div>

            {{-- Tab: Sejarah --}}
            <div data-tab-panel="sejarah" class="tab-panel hidden p-6">
                <p class="text-sm text-neutral-600 leading-relaxed">{{ $rumah['sejarah'] }}</p>
            </div>

            {{-- Tab: Galeri --}}
            <div data-tab-panel="galeri" class="tab-panel hidden p-6 grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach ($rumah['galeri'] as $foto)
                    <div class="h-28 rounded-lg bg-green-900/5 border border-dashed border-green-900/20 overflow-hidden">
                        {{-- TEMPAT FILE FOTO: {{ $foto }} --}}
                        <img src="" alt="{{ $foto }}" class="w-full h-full object-cover" onerror="this.style.display='none'">
                    </div>
                @endforeach
            </div>

            {{-- Tab: Video --}}
            <div data-tab-panel="video" class="tab-panel hidden p-6">
                <div class="h-64 rounded-xl bg-green-900/5 border border-dashed border-green-900/20 flex items-center justify-center text-sm text-neutral-500">
                    Belum ada video untuk rumah ini
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let lokasiMap;

    function initLokasiMap() {
        if (lokasiMap) return;
        lokasiMap = L.map('lokasi-map', {
            zoomControl: false,
            dragging: false,
            scrollWheelZoom: false,
        }).setView([{{ $rumah['lat'] }}, {{ $rumah['lng'] }}], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(lokasiMap);

        L.marker([{{ $rumah['lat'] }}, {{ $rumah['lng'] }}]).addTo(lokasiMap);
    }

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

        if (key === 'informasi') {
            initLokasiMap();
            setTimeout(() => lokasiMap && lokasiMap.invalidateSize(), 50);
        }
    }

    document.addEventListener('DOMContentLoaded', initLokasiMap);
</script>
@endpush