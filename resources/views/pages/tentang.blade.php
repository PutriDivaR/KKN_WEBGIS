@extends('layouts.app')

@section('title', 'Tentang — WebGIS Kampung Adat Sijunjung')

@section('content')

    @php
        $icons = [
            'info'     => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
            'document' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
            'sparkles' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z',
            'pin'      => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z',
            'shield'   => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
            'users'    => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
            'check'    => 'M4.5 12.75l6 6 9-13.5',
            'arrow'    => 'M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3',
        ];

        $tabs = [
            'tentang'     => ['label' => 'Tentang Kampung Adat',     'icon' => 'info'],
            'dokumentasi' => ['label' => 'Dokumentasi Kampung Adat', 'icon' => 'document'],
            'budaya'      => ['label' => 'Budaya',                  'icon' => 'sparkles'],
        ];
    @endphp

    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-[240px_1fr] gap-8">

            {{-- Sidebar nav --}}
            <aside class="lg:sticky lg:top-24 h-fit">
                <nav class="bg-white rounded-2xl border border-neutral-100 p-2 flex lg:flex-col overflow-x-auto lg:overflow-visible gap-1">
                    @foreach ($tabs as $key => $tab)
                        <button
                            type="button"
                            data-tentang-btn="{{ $key }}"
                            onclick="switchTentangTab('{{ $key }}')"
                            class="tentang-btn flex items-center gap-2.5 shrink-0 lg:w-full text-left px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ $loop->first ? 'bg-green-50 text-green-700' : 'text-neutral-600 hover:bg-neutral-50' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$tab['icon']] }}" />
                            </svg>
                            <span class="whitespace-nowrap lg:whitespace-normal">{{ $tab['label'] }}</span>
                        </button>
                    @endforeach
                </nav>
            </aside>

            {{-- Panels --}}
            <div>

                {{-- ============ TAB: TENTANG KAMPUNG ADAT ============ --}}
                <div data-tentang-panel="tentang">
                    <h1 class="text-2xl md:text-3xl font-bold text-green-900">Tentang Kampung Adat</h1>
                    <div class="w-14 h-1 bg-green-600 rounded-full mt-3 mb-6"></div>

                    <div class="space-y-4 text-neutral-600 leading-relaxed max-w-3xl">
                        <p>{{ $tentang['isi_sejarah'] }}</p>
                        <p>{{ $tentang['paragraf_dua'] }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
                        @foreach ([
                            ['icon' => 'pin',    'label' => 'Lokasi',      'value' => $tentang['lokasi']],
                            ['icon' => 'shield', 'label' => 'Status',      'value' => $tentang['status_kawasan']],
                            ['icon' => 'users',  'label' => 'Masyarakat',  'value' => $tentang['masyarakat']],
                        ] as $card)
                            <div class="bg-white rounded-2xl border border-neutral-100 p-5 text-center">
                                <div class="w-11 h-11 mx-auto rounded-xl bg-green-50 text-green-700 flex items-center justify-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$card['icon']] }}" />
                                    </svg>
                                </div>
                                <p class="font-semibold text-green-900 text-sm">{{ $card['label'] }}</p>
                                <p class="text-xs text-neutral-500 mt-1 leading-relaxed">{{ $card['value'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- TEMPAT FILE FOTO KAMPUNG --}}
                    <div class="mt-6 rounded-2xl overflow-hidden h-72 md:h-[26rem] bg-green-900/5 border border-dashed border-green-900/20 relative max-w-3xl">
                        <img src="" alt="Kampung Adat Sijunjung" class="w-full h-full object-cover" onerror="this.style.display='none'">
                    </div>
                </div>

                {{-- ============ TAB: DOKUMENTASI KAMPUNG ADAT ============ --}}
                <div data-tentang-panel="dokumentasi" class="hidden">
                    <h1 class="text-2xl md:text-3xl font-bold text-green-900">Dokumentasi Kampung Adat</h1>
                    <div class="w-14 h-1 bg-green-600 rounded-full mt-3 mb-4"></div>

                    <p class="text-neutral-600 leading-relaxed max-w-2xl mb-3">
                        Berbagai dokumen, foto, dan arsip penting yang merekam perjalanan, pembangunan, serta pelestarian Kampung Adat Sijunjung.
                    </p>

                    <div class="flex items-start gap-2.5 text-xs text-neutral-600 bg-neutral-50 border border-neutral-100 rounded-xl p-3 max-w-2xl mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0 mt-0.5 text-neutral-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['info'] }}" />
                        </svg>
                        <span>Halaman ini masih dalam pengembangan (on progress) — konten dokumentasi asli dari tim arsitektur akan menggantikan placeholder di bawah ini.</span>
                    </div>

                    {{-- Dokumentasi utama (placeholder) --}}
                    <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="h-56 md:h-auto bg-green-900/5 border-r border-neutral-100 relative">
                                {{-- TEMPAT FILE FOTO DOKUMENTASI UTAMA --}}
                                <img src="" alt="Dokumentasi Utama" class="w-full h-full object-cover" onerror="this.style.display='none'">
                            </div>
                            <div class="p-6 flex flex-col justify-center">
                                <span class="inline-block w-fit text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full mb-3">
                                    Dokumentasi Utama
                                </span>
                                <h3 class="font-semibold text-green-900 mb-2">Judul Dokumentasi Utama</h3>
                                <p class="text-sm text-neutral-500 leading-relaxed mb-4">
                                    Placeholder deskripsi dokumentasi utama — akan diisi begitu materi dari tim arsitektur tersedia.
                                </p>
                                <span class="inline-flex items-center gap-1 text-sm font-medium text-neutral-400 cursor-not-allowed" title="Belum tersedia">
                                    Lihat Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['arrow'] }}" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Koleksi dokumentasi (placeholder) --}}
                    <p class="font-semibold text-green-900 mb-4">Koleksi Dokumentasi</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach (['Dokumen 1', 'Dokumen 2', 'Dokumen 3'] as $placeholder)
                            <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden">
                                <div class="h-36 bg-green-900/5 border-b border-neutral-100 relative">
                                    <img src="" alt="{{ $placeholder }}" class="w-full h-full object-cover" onerror="this.style.display='none'">
                                </div>
                                <div class="p-4">
                                    <h4 class="font-medium text-neutral-800 text-sm">{{ $placeholder }}</h4>
                                    <p class="text-xs text-neutral-400 mt-1 leading-relaxed">Deskripsi singkat menyusul.</p>
                                    <span class="inline-flex items-center gap-1 mt-3 text-xs font-medium text-neutral-400 cursor-not-allowed" title="Belum tersedia">
                                        Lihat Detail
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['arrow'] }}" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ============ TAB: BUDAYA (dari DB) ============ --}}
                <div data-tentang-panel="budaya" class="hidden">
                    <h1 class="text-2xl md:text-3xl font-bold text-green-900">Budaya Kampung Adat Sijunjung</h1>
                    <div class="w-14 h-1 bg-green-600 rounded-full mt-3 mb-6"></div>

                    <p class="text-neutral-600 leading-relaxed max-w-2xl mb-8">
                        Kekayaan budaya yang menjadi jati diri masyarakat Kampung Adat Sijunjung diwariskan secara turun-temurun.
                    </p>

            @if ($budayaList->isNotEmpty())

                @php
                    $half = ceil($budayaList->count() / 2);
                    $leftBudaya = $budayaList->take($half);
                    $rightBudaya = $budayaList->slice($half);
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                    {{-- ================= KOLOM KIRI ================= --}}
                    <div class="space-y-3">
                        @foreach ($leftBudaya as $b)

                            <div id="budaya-item-{{ $b->id_budaya }}"
                                class="bg-white rounded-2xl border border-neutral-100 overflow-hidden transition">

                                <button
                                    type="button"
                                    onclick="toggleBudaya({{ $b->id_budaya }})"
                                    class="w-full flex items-center justify-between gap-3 px-4 py-3.5 text-left">

                                    <div class="flex items-center gap-3 min-w-0">

                                        <div class="w-8 h-8 rounded-full bg-green-600 text-white text-xs font-semibold flex items-center justify-center shrink-0">
                                            {{ sprintf('%02d', $loop->iteration) }}
                                        </div>

                                        <span class="font-medium text-neutral-800 text-sm">
                                            {{ $b->nama }}
                                        </span>

                                    </div>

                                    <svg id="budaya-chevron-{{ $b->id_budaya }}"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="w-4 h-4 text-neutral-400 transition-transform">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                    </svg>

                                </button>

                                <div id="budaya-panel-{{ $b->id_budaya }}"
                                    class="hidden border-t border-neutral-100">

                                    <div class="max-h-56 overflow-y-auto px-4 py-4 text-sm leading-7 text-neutral-600">
                                        {{ $b->deskripsi ?: 'Deskripsi belum tersedia.' }}
                                    </div>

                                </div>

                            </div>

                        @endforeach
                    </div>

                    {{-- ================= KOLOM KANAN ================= --}}
                    <div class="space-y-3">
                        @foreach ($rightBudaya as $b)

                            <div id="budaya-item-{{ $b->id_budaya }}"
                                class="bg-white rounded-2xl border border-neutral-100 overflow-hidden transition">

                                <button
                                    type="button"
                                    onclick="toggleBudaya({{ $b->id_budaya }})"
                                    class="w-full flex items-center justify-between gap-3 px-4 py-3.5 text-left">

                                    <div class="flex items-center gap-3 min-w-0">

                                        <div class="w-8 h-8 rounded-full bg-green-600 text-white text-xs font-semibold flex items-center justify-center shrink-0">
                                            {{ sprintf('%02d', $half + $loop->iteration) }}
                                        </div>

                                        <span class="font-medium text-neutral-800 text-sm">
                                            {{ $b->nama }}
                                        </span>

                                    </div>

                                    <svg id="budaya-chevron-{{ $b->id_budaya }}"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="w-4 h-4 text-neutral-400 transition-transform">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                    </svg>

                                </button>

                                <div id="budaya-panel-{{ $b->id_budaya }}"
                                    class="hidden border-t border-neutral-100">

                                    <div class="max-h-56 overflow-y-auto px-4 py-4 text-sm leading-7 text-neutral-600">
                                        {{ $b->deskripsi ?: 'Deskripsi belum tersedia.' }}
                                    </div>

                                </div>

                            </div>

                        @endforeach
                    </div>

                </div>

            @else
                        <div class="bg-white rounded-2xl border border-dashed border-neutral-200 p-10 text-center">
                            <p class="text-sm text-neutral-400">Data budaya belum tersedia di database.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    function switchTentangTab(key) {
        document.querySelectorAll('[data-tentang-panel]').forEach(el => el.classList.add('hidden'));
        document.querySelector(`[data-tentang-panel="${key}"]`).classList.remove('hidden');

        document.querySelectorAll('.tentang-btn').forEach(btn => {
            const active = btn.dataset.tentangBtn === key;
            btn.classList.toggle('bg-green-50', active);
            btn.classList.toggle('text-green-700', active);
            btn.classList.toggle('text-neutral-600', !active);
        });
    }

    function toggleBudaya(id) {
        const panel = document.getElementById(`budaya-panel-${id}`);
        const chevron = document.getElementById(`budaya-chevron-${id}`);
        const item = document.getElementById(`budaya-item-${id}`);
        if (!panel || !chevron || !item) return;

        const isOpen = !panel.classList.contains('hidden');

        if (isOpen) {
            panel.classList.add('hidden');
            chevron.classList.remove('rotate-180');
            item.classList.remove('bg-green-50', 'border-green-100');
            item.classList.add('border-neutral-100');
        } else {
            panel.classList.remove('hidden');
            chevron.classList.add('rotate-180');
            item.classList.remove('border-neutral-100');
            item.classList.add('bg-green-50', 'border-green-100');
        }
    }
</script>
@endpush