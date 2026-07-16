@extends('layouts.app')

@section('title', 'Perancangan Kawasan — WebGIS Kampung Adat Sijunjung')

@section('content')

    @php
        $icons = [
            'home'        => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
            'komersial'   => 'M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z',
            'tugu'        => 'M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5',
            'streetscape' => 'M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.875 2.437c.317.158.69.158 1.006 0z',
        ];

        $colorMap = [
            'green'  => ['bg' => 'bg-green-600',  'dot' => 'bg-green-600'],
            'blue'   => ['bg' => 'bg-blue-600',   'dot' => 'bg-blue-600'],
            'orange' => ['bg' => 'bg-orange-500', 'dot' => 'bg-orange-500'],
            'red'    => ['bg' => 'bg-red-600',    'dot' => 'bg-red-600'],
            'purple' => ['bg' => 'bg-purple-600', 'dot' => 'bg-purple-600'],
        ];

        $legenda = collect($items)->map(fn ($i) => ['label' => $i['legenda'], 'warna' => $i['warna']])->unique('label');
    @endphp

    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-10 grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6">

        {{-- Sidebar --}}
        <aside>
            <h1 class="text-2xl font-bold text-green-900">Perancangan Kawasan</h1>
            <p class="mt-3 text-sm text-neutral-600 leading-relaxed">
                Halaman ini menampilkan usulan pengembangan kawasan Kampung Adat Sijunjung
                yang disusun oleh Tim KKN Tematik UNAND 2026.
            </p>

            <div class="mt-5 flex gap-2.5 text-xs text-neutral-600 bg-neutral-50 border border-neutral-100 rounded-xl p-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0 mt-0.5 text-neutral-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                <span>Seluruh isi halaman merupakan konsep desain (future plan), bukan kondisi eksisting.</span>
            </div>

            <div class="mt-6">
                <p class="text-sm font-semibold text-green-900 mb-3">Legenda</p>
                <ul class="space-y-2.5 text-sm text-neutral-600">
                    @foreach ($legenda as $l)
                        <li class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full {{ $colorMap[$l['warna']]['dot'] }} inline-block"></span>
                            {{ $l['label'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- Siteplan --}}
        <div>
            <div class="relative rounded-2xl overflow-hidden border border-neutral-100 bg-green-900/5 h-[65vh] min-h-[420px]">

                {{-- TEMPAT FILE GAMBAR SITEPLAN --}}
                {{-- Ganti src dengan gambar siteplan asli kiriman tim arsitektur --}}
                <img
                    src="{{ asset('assets/siteplan(dummy).png') }}"
                    alt="Siteplan Kawasan Kampung Adat Sijunjung"
                    class="absolute inset-0 w-full h-full object-cover"
                    onerror="this.style.display='none'"
                >

                {{-- Kompas dekoratif --}}
                <div class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/90 shadow flex items-center justify-center text-xs font-semibold text-neutral-500">
                    N
                </div>

                {{-- Markers --}}
                @foreach ($items as $item)
                    <button
                        type="button"
                        data-marker="{{ $item['slug'] }}"
                        onclick="openPopup('{{ $item['slug'] }}', this)"
                        style="top: {{ $item['posisi_top'] }}%; left: {{ $item['posisi_left'] }}%;"
                        class="absolute -translate-x-1/2 -translate-y-full w-9 h-9 rounded-full {{ $colorMap[$item['warna']]['bg'] }} border-2 border-white shadow-lg flex items-center justify-center text-white hover:scale-110 transition-transform"
                        aria-label="{{ $item['nama'] }}"
                    >
                        @if ($item['icon'] === 'parkir')
                            <span class="text-sm font-bold">P</span>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$item['icon']] }}" />
                            </svg>
                        @endif
                    </button>
                @endforeach

                {{-- Popup kartu ringkasan --}}
                @foreach ($items as $item)
                    <div
                        id="popup-{{ $item['slug'] }}"
                        class="popup-card hidden absolute z-20 w-64 bg-white rounded-2xl shadow-xl border border-neutral-100 overflow-hidden"
                        style="top: {{ $item['posisi_top'] }}%; left: {{ $item['posisi_left'] }}%;"
                    >
                        <div class="flex items-center justify-between px-4 py-3 border-b border-neutral-100">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-md {{ $colorMap[$item['warna']]['bg'] }} flex items-center justify-center text-white">
                                    @if ($item['icon'] === 'parkir')
                                        <span class="text-[10px] font-bold">P</span>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$item['icon']] }}" />
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-sm font-semibold text-neutral-800">{{ $item['nama'] }}</p>
                            </div>
                            <button type="button" onclick="closePopup('{{ $item['slug'] }}')" class="text-neutral-400 hover:text-neutral-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="h-32 bg-green-900/5">
                            <img src="{{ $item['foto_utama'] }}" alt="{{ $item['nama'] }}" class="w-full h-full object-cover" onerror="this.style.display='none'">
                        </div>

                        <div class="p-4">
                            <p class="text-sm text-neutral-600 leading-relaxed">{{ $item['ringkasan'] }}</p>
                            <a href="{{ route('perancangan.show', $item['slug']) }}" class="inline-flex items-center gap-1 mt-3 text-sm font-medium text-green-700 hover:underline">
                                Lihat Detail
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 flex items-center gap-2 text-sm text-neutral-500 bg-neutral-50 border border-neutral-100 rounded-xl px-4 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-neutral-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 6.257L6.166 4.666M4.5 12H2.25m4.007 5.743l1.591-1.591M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Klik pada marker di peta untuk melihat detail rencana pengembangan.
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    function openPopup(slug, btn) {
        document.querySelectorAll('.popup-card').forEach(el => el.classList.add('hidden'));
        const popup = document.getElementById('popup-' + slug);
        if (!popup) return;

        const container = btn.closest('.relative');
        const containerWidth = container.offsetWidth;
        const markerLeftPct = parseFloat(btn.style.left);
        const popupWidth = 256; // w-64

        let leftPx = (markerLeftPct / 100) * containerWidth + 24;
        if (leftPx + popupWidth > containerWidth - 12) {
            leftPx = (markerLeftPct / 100) * containerWidth - popupWidth - 24;
        }
        popup.style.left = leftPx + 'px';
        popup.style.top = btn.style.top;
        popup.style.transform = 'translateY(-20%)';

        popup.classList.remove('hidden');
    }

    function closePopup(slug) {
        document.getElementById('popup-' + slug)?.classList.add('hidden');
    }
</script>
@endpush