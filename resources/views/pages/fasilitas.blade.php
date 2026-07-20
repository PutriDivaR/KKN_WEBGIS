@extends('layouts.app')

@section('title', 'Fasilitas — Kampung Adat Sijunjung')

@section('content')

    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <h1 class="text-2xl md:text-3xl font-bold text-green-900">Fasilitas Kampung Adat</h1>
        <p class="mt-2 text-neutral-600 max-w-2xl">
            Temukan fasilitas yang tersedia di Kampung Adat Sijunjung.
        </p>
    </section>

    <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-24 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($fasilitas as $index => $item)
            <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden hover:shadow-lg transition-shadow flex flex-col">
                <img
                    src="{{ $item['thumbnail'] ?? 'https://placehold.co/500x320/2f4a37/e8efe9?text=' . urlencode($item['nama']) }}"
                    alt="{{ $item['nama'] }}"
                    class="w-full h-44 object-cover bg-neutral-100"
                    onerror="this.onerror=null; this.src='https://placehold.co/500x320/2f4a37/e8efe9?text={{ urlencode($item['nama']) }}'"
                >
                <div class="p-5 flex flex-col flex-1">
                    <div class="flex flex-wrap gap-1.5">
                        <span class="inline-block text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                            {{ $item['kategori'] }}
                        </span>
                        @if ($item['jorong'])
                            <span class="inline-block text-xs font-medium text-neutral-500 bg-neutral-100 px-2.5 py-1 rounded-full">
                                Jorong {{ $item['jorong'] }}
                            </span>
                        @endif
                    </div>

                    <h3 class="font-semibold text-green-900 mt-3">{{ $item['nama'] }}</h3>
                    <p class="text-sm text-neutral-600 mt-1 leading-relaxed">
                        {{ $item['ringkasan'] ?? 'Belum ada deskripsi untuk fasilitas ini.' }}
                    </p>

                    <button
                        type="button"
                        onclick="openFasilitasModal({{ $index }})"
                        class="inline-flex items-center gap-1 mt-4 text-sm text-green-700 font-medium hover:underline mt-auto pt-4"
                    >
                        Lihat Detail
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-neutral-500 py-16">
                Belum ada data fasilitas di database.
            </p>
        @endforelse
    </section>

    {{-- ============ MODAL DETAIL FASILITAS ============ --}}
    <div
        id="fasilitasModal"
        class="hidden fixed inset-0 z-50 bg-black/70 items-center justify-center p-4"
        onclick="closeFasilitasModalBackdrop(event)"
    >
        <div class="relative bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">

            <button
                type="button"
                onclick="closeFasilitasModal()"
                class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-white shadow flex items-center justify-center text-neutral-500 hover:text-green-800"
                aria-label="Tutup"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-2">

                {{-- Media: foto utama + thumbnail --}}
                <div class="bg-neutral-900 md:rounded-l-2xl flex flex-col">
                    <div id="modalMainMedia" class="h-64 md:h-full min-h-[18rem] flex items-center justify-center overflow-hidden bg-neutral-900"></div>
                    <div id="modalThumbs" class="flex gap-2 overflow-x-auto p-3 bg-black/40 [&::-webkit-scrollbar]:hidden"></div>
                </div>

                {{-- Deskripsi --}}
                <div class="p-6">
                    <div class="flex flex-wrap gap-1.5">
                        <span id="modalKategori" class="inline-block text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full"></span>
                        <span id="modalJorong" class="hidden text-xs font-medium text-neutral-500 bg-neutral-100 px-2.5 py-1 rounded-full"></span>
                    </div>

                    <h2 id="modalNama" class="text-xl font-bold text-green-900 mt-3"></h2>
                    <p id="modalDeskripsi" class="text-sm text-neutral-600 mt-3 leading-relaxed whitespace-pre-line"></p>

                    <a
                        id="modalMapLink"
                        href="#"
                        target="_blank"
                        rel="noopener"
                        class="hidden inline-flex items-center gap-1.5 mt-6 text-sm text-green-700 font-medium hover:underline"
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

    <script>
        const fasilitasData = @json($fasilitas);
        let currentMedia = [];

        function openFasilitasModal(index) {
            const item = fasilitasData[index];
            if (!item) return;

            document.getElementById('modalNama').textContent = item.nama;
            document.getElementById('modalKategori').textContent = item.kategori;
            document.getElementById('modalDeskripsi').textContent =
                item.deskripsi && item.deskripsi.trim() !== ''
                    ? item.deskripsi
                    : 'Belum ada deskripsi untuk fasilitas ini.';

            const jorongEl = document.getElementById('modalJorong');
            if (item.jorong) {
                jorongEl.textContent = 'Jorong ' + item.jorong;
                jorongEl.classList.remove('hidden');
            } else {
                jorongEl.classList.add('hidden');
            }

            const mapLink = document.getElementById('modalMapLink');
            if (item.latitude && item.longitude) {
                mapLink.href = `https://www.google.com/maps?q=${item.latitude},${item.longitude}`;
                mapLink.classList.remove('hidden');
            } else {
                mapLink.classList.add('hidden');
            }

            currentMedia = Array.isArray(item.media) ? item.media : [];
            renderModalThumbs();

            if (currentMedia.length) {
                showModalMedia(0);
            } else {
                document.getElementById('modalMainMedia').innerHTML =
                    `<img src="https://placehold.co/600x450/2f4a37/e8efe9?text=${encodeURIComponent(item.nama)}" class="w-full h-full object-cover">`;
            }

            const modal = document.getElementById('fasilitasModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function renderModalThumbs() {
            const wrap = document.getElementById('modalThumbs');
            wrap.innerHTML = '';

            if (currentMedia.length <= 1) return;

            currentMedia.forEach((m, i) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.title = m.nama || '';
                btn.className = 'shrink-0 w-16 h-12 rounded-md overflow-hidden border-2 border-transparent hover:border-green-400 transition';
                btn.onclick = () => showModalMedia(i);

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

        function showModalMedia(i) {
            const m = currentMedia[i];
            const box = document.getElementById('modalMainMedia');
            if (!m) return;

            if (m.jenis === 'video') {
                box.innerHTML = `<video src="${m.url}" class="w-full h-full object-contain" controls autoplay></video>`;
            } else {
                box.innerHTML = `<img src="${m.url}" alt="${m.nama || ''}" class="w-full h-full object-contain">`;
            }
        }

        function closeFasilitasModal() {
            const modal = document.getElementById('fasilitasModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('modalMainMedia').innerHTML = '';
            document.body.style.overflow = '';
        }

        function closeFasilitasModalBackdrop(event) {
            if (event.target.id === 'fasilitasModal') {
                closeFasilitasModal();
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeFasilitasModal();
        });
    </script>

@endsection