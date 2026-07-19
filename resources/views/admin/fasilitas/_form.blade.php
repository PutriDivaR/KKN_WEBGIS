@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@php
    $isEdit = $fasilitas->exists;
    $actionUrl = $isEdit
        ? route('admin.fasilitas.update', $fasilitas->id_fasilitas)
        : route('admin.fasilitas.store');
@endphp

@if (session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
        <p class="font-medium mb-1">Periksa kembali isian Anda:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $actionUrl }}" enctype="multipart/form-data" id="fasilitas-form">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    {{-- ===================== INFORMASI DASAR ===================== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-[#e5ece3] p-8 mb-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="bi bi-info-circle text-[#132018] text-lg"></i>
            <h2 class="text-lg font-semibold text-[#132018]">Informasi Dasar</h2>
        </div>
        <div class="border-b border-[#e5ece3] mb-6"></div>

        <div class="space-y-6">
            {{-- Nama Fasilitas --}}
            <div>
                <label for="nama" class="block text-xs font-semibold uppercase tracking-wide text-[#56715d] mb-2">
                    Nama Fasilitas
                </label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama', $fasilitas->nama) }}"
                    placeholder="Contoh: Masjid Raya Al-Hikmah"
                    class="w-full px-4 py-2.5 rounded-xl border border-[#d9e3d8] bg-[#f9faf8] text-sm text-[#132018] focus:outline-none focus:ring-2 focus:ring-[#2f5a36]/20 focus:border-[#2f5a36]"
                    required
                >
            </div>

            {{-- Kategori & Jorong --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="kategori" class="block text-xs font-semibold uppercase tracking-wide text-[#56715d] mb-2">
                        Kategori
                    </label>
                    <select id="kategori" name="kategori"
                            class="w-full px-4 py-2.5 rounded-xl border border-[#d9e3d8] bg-[#f9faf8] text-sm text-[#132018] focus:outline-none focus:ring-2 focus:ring-[#2f5a36]/20 focus:border-[#2f5a36]">
                        <option value="" {{ old('kategori', $fasilitas->kategori) === null ? 'selected' : '' }}>Pilih Kategori</option>
                        @foreach (\App\Models\FasilitasWisata::KATEGORI_OPTIONS as $option)
                            <option value="{{ $option }}" {{ old('kategori', $fasilitas->kategori) === $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="id_jorong" class="block text-xs font-semibold uppercase tracking-wide text-[#56715d] mb-2">
                        Jorong
                    </label>
                    <select id="id_jorong" name="id_jorong"
                            class="w-full px-4 py-2.5 rounded-xl border border-[#d9e3d8] bg-[#f9faf8] text-sm text-[#132018] focus:outline-none focus:ring-2 focus:ring-[#2f5a36]/20 focus:border-[#2f5a36]">
                        <option value="">Pilih Jorong</option>
                        @foreach ($jorongList as $j)
                            <option value="{{ $j->id_jorong }}" {{ (int) old('id_jorong', $fasilitas->id_jorong) === $j->id_jorong ? 'selected' : '' }}>
                                {{ $j->nama_jorong }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Longitude & Latitude (dipilih lewat peta) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-[#56715d] mb-2">
                        Longitude
                    </label>
                    <button type="button" id="btn-open-map"
                            class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl border border-[#d9e3d8] bg-[#f9faf8] text-sm text-left focus:outline-none focus:ring-2 focus:ring-[#2f5a36]/20">
                        <span id="display-longitude" class="text-[#132018]">
                            {{ old('longitude', $fasilitas->longitude) ?: 'Titik Koordinat' }}
                        </span>
                        <i class="bi bi-chevron-down text-[#8b9a8f] shrink-0"></i>
                    </button>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-[#56715d] mb-2">
                        Latitude
                    </label>
                    <button type="button" id="btn-open-map-2"
                            class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl border border-[#d9e3d8] bg-[#f9faf8] text-sm text-left focus:outline-none focus:ring-2 focus:ring-[#2f5a36]/20">
                        <span id="display-latitude" class="text-[#132018]">
                            {{ old('latitude', $fasilitas->latitude) ?: 'Titik Koordinat' }}
                        </span>
                        <i class="bi bi-chevron-down text-[#8b9a8f] shrink-0"></i>
                    </button>
                </div>

                {{-- nilai sesungguhnya yang dikirim ke server --}}
                <input type="hidden" name="longitude" id="input-longitude" value="{{ old('longitude', $fasilitas->longitude) }}">
                <input type="hidden" name="latitude" id="input-latitude" value="{{ old('latitude', $fasilitas->latitude) }}">
                <p class="sm:col-span-2 -mt-3 text-xs text-[#8b9a8f]">Klik salah satu kolom di atas untuk memilih titik lokasi pada peta.</p>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="block text-xs font-semibold uppercase tracking-wide text-[#56715d] mb-2">
                    Deskripsi Detail
                </label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="4"
                    placeholder="Jelaskan fungsi, kapasitas, dan jam operasional fasilitas..."
                    class="w-full px-4 py-3 rounded-xl border border-[#d9e3d8] bg-[#f9faf8] text-sm text-[#132018] focus:outline-none focus:ring-2 focus:ring-[#2f5a36]/20 focus:border-[#2f5a36]"
                >{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
            </div>
        </div>
    </div>

    {{-- ===================== GALERI FOTO (maks. 1 foto) ===================== --}}
    @php
        $existingPhoto = $isEdit ? $fasilitas->media->firstWhere('jenis_media', 'foto') : null;
    @endphp
    <div class="bg-white rounded-2xl shadow-sm border border-[#e5ece3] p-8 mb-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="bi bi-images text-[#132018] text-lg"></i>
            <h2 class="text-lg font-semibold text-[#132018]">Foto Fasilitas</h2>
        </div>
        <div class="border-b border-[#e5ece3] mb-6"></div>

        <div class="w-full max-w-xs">
            <div id="photo-box"
                 class="relative w-full aspect-video rounded-xl border-2 overflow-hidden bg-[#f9faf8]
                        {{ $existingPhoto ? 'border-solid border-[#d9e3d8]' : 'border-dashed border-[#d9e3d8]' }}">

                {{-- Foto tersimpan (dari database) --}}
                <img id="saved-photo-img"
                     src="{{ $existingPhoto?->url }}"
                     class="w-full h-full object-cover {{ $existingPhoto ? '' : 'hidden' }}">

                {{-- Preview foto baru yang baru dipilih (belum disimpan ke server) --}}
                <img id="new-photo-img" src="" alt="" class="w-full h-full object-cover hidden">

                {{-- Placeholder saat belum ada foto sama sekali --}}
                <label for="foto-input" id="empty-placeholder"
                       class="w-full h-full flex flex-col items-center justify-center gap-2 text-[#6d7f72] hover:text-[#2f5a36] cursor-pointer transition {{ $existingPhoto ? 'hidden' : '' }}">
                    <i class="bi bi-camera text-xl"></i>
                    <span class="text-xs font-medium tracking-wide">TAMBAH FOTO</span>
                </label>

                {{-- Tombol "ganti foto" (muncul kalau sudah ada gambar tersimpan) --}}
                <label for="foto-input" id="btn-replace"
                       class="absolute bottom-2 right-2 h-8 w-8 rounded-full bg-white/90 hover:bg-white text-[#2f5a36] border border-[#d9e3d8] flex items-center justify-center cursor-pointer shadow transition {{ $existingPhoto ? '' : 'hidden' }}"
                       title="Ganti foto">
                    <i class="bi bi-camera text-sm"></i>
                </label>

                {{-- Tombol hapus foto TERSIMPAN — tombol biasa (BUKAN <form>), karena
                     form ini berada di dalam <form id="fasilitas-form">. Form hapus
                     yang sesungguhnya ada di LUAR form utama, lihat setelah tag
                     </form> di bawah, supaya tidak ada <form> bersarang. --}}
                @if ($existingPhoto)
                    <button type="button" id="delete-saved-photo-btn" title="Hapus foto"
                            class="absolute top-2 right-2 h-7 w-7 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow">
                        <i class="bi bi-x-lg text-xs"></i>
                    </button>
                @endif

                {{-- Tombol batal untuk foto BARU yang belum disimpan (hanya reset pilihan, tidak menghapus apapun di server) --}}
                <button type="button" id="cancel-new-photo" title="Batalkan pilihan"
                        class="hidden absolute top-2 right-2 h-7 w-7 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center shadow">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <input type="file" id="foto-input" name="foto" accept="image/png, image/jpeg, image/webp" class="hidden">
        </div>

        <p class="text-xs text-[#8b9a8f] italic mt-4">
            Satu fasilitas hanya bisa memiliki 1 foto. Memilih foto baru akan menggantikan foto lama.
            Format: JPG, PNG, WEBP (Maks. 5MB).
        </p>
    </div>

    {{-- ===================== FOOTER ACTIONS ===================== --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.fasilitas.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-[#d9e3d8] text-[#374b3a] text-sm font-medium hover:bg-[#edf3ea]">
            <i class="bi bi-x-lg"></i>
            Batal
        </a>
        <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#2f5a36] hover:bg-[#244529] text-white text-sm font-medium shadow-sm">
            <i class="bi bi-check-lg"></i>
            Simpan Fasilitas
        </button>
    </div>
</form>

{{-- ===================== FORM TERPISAH: HAPUS FOTO TERSIMPAN ===================== --}}
{{-- Sengaja dipisah dari form utama di atas — <form> tidak boleh bersarang
     di dalam <form> lain. Sebelumnya form ini ditulis nested, dan itu bikin
     browser menutup form utama lebih awal (tepat di </form> milik form ini),
     sehingga tombol "Simpan Fasilitas" ikut "terlempar" keluar dari form
     utama dan tidak berfungsi sama sekali saat diklik. --}}
@if ($isEdit && $existingPhoto)
    <form action="{{ route('admin.fasilitas.media.destroy', $existingPhoto->id_medfas) }}" method="POST"
          id="delete-saved-photo-form" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endif

{{-- ===================== MODAL PETA PILIH TITIK KOORDINAT ===================== --}}
<div id="map-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#e5ece3]">
            <h3 class="font-semibold text-[#132018]">Pilih Titik Koordinat</h3>
            <button type="button" id="btn-close-map" class="text-[#8b9a8f] hover:text-[#4d6150]">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div id="leaflet-map" class="w-full" style="height: 380px;"></div>
        <div class="flex items-center justify-between px-6 py-4 border-t border-[#e5ece3]">
            <p class="text-xs text-[#56715d]">
                Terpilih: <span id="modal-coord-preview">-</span>
            </p>
            <button type="button" id="btn-confirm-coord"
                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-[#2f5a36] hover:bg-[#244529] text-white text-sm font-medium">
                Gunakan Titik Ini
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function () {
    // ---------- Foto fasilitas: preview single-file & batal pilihan ----------
    const fotoInput = document.getElementById('foto-input');
    const savedImg = document.getElementById('saved-photo-img');
    const newImg = document.getElementById('new-photo-img');
    const placeholder = document.getElementById('empty-placeholder');
    const btnReplace = document.getElementById('btn-replace');
    const deleteSavedBtn = document.getElementById('delete-saved-photo-btn');
    const deleteSavedForm = document.getElementById('delete-saved-photo-form');
    const cancelNewBtn = document.getElementById('cancel-new-photo');

    // Tombol hapus foto tersimpan men-submit form tersembunyi yang berada
    // di luar form utama (lihat markup setelah </form> di atas).
    if (deleteSavedBtn && deleteSavedForm) {
        deleteSavedBtn.addEventListener('click', function () {
            if (confirm('Hapus foto ini? Foto akan langsung terhapus dari server.')) {
                deleteSavedForm.submit();
            }
        });
    }

    fotoInput.addEventListener('change', function () {
        const file = fotoInput.files[0];
        if (!file) return;

        const url = URL.createObjectURL(file);
        newImg.src = url;
        newImg.classList.remove('hidden');

        savedImg.classList.add('hidden');
        placeholder.classList.add('hidden');
        btnReplace.classList.add('hidden');
        if (deleteSavedBtn) deleteSavedBtn.classList.add('hidden');

        cancelNewBtn.classList.remove('hidden');
    });

    cancelNewBtn.addEventListener('click', function () {
        fotoInput.value = '';
        newImg.src = '';
        newImg.classList.add('hidden');
        cancelNewBtn.classList.add('hidden');

        const hasSaved = savedImg.getAttribute('src') && savedImg.getAttribute('src').trim() !== '';
        if (hasSaved) {
            savedImg.classList.remove('hidden');
            btnReplace.classList.remove('hidden');
            if (deleteSavedBtn) deleteSavedBtn.classList.remove('hidden');
        } else {
            placeholder.classList.remove('hidden');
        }
    });

    // ---------- Peta pemilih koordinat ----------
    const DEFAULT_CENTER = [-0.7075, 100.9850]; // Perkampungan Adat Sijunjung
    const modal = document.getElementById('map-modal');
    const inputLng = document.getElementById('input-longitude');
    const inputLat = document.getElementById('input-latitude');
    const displayLng = document.getElementById('display-longitude');
    const displayLat = document.getElementById('display-latitude');
    const coordPreview = document.getElementById('modal-coord-preview');

    let map, marker, tempCoord = null;

    function openMap() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        if (!map) {
            map = L.map('leaflet-map');
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            map.on('click', function (e) {
                setMarker(e.latlng.lat, e.latlng.lng);
            });
        }

        const existingLat = parseFloat(inputLat.value);
        const existingLng = parseFloat(inputLng.value);
        const startLatLng = (!isNaN(existingLat) && !isNaN(existingLng))
            ? [existingLat, existingLng]
            : DEFAULT_CENTER;

        setTimeout(() => {
            map.invalidateSize();
            map.setView(startLatLng, 16);
            setMarker(startLatLng[0], startLatLng[1]);
        }, 50);
    }

    function setMarker(lat, lng) {
        tempCoord = { lat, lng };
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function () {
                const pos = marker.getLatLng();
                setMarker(pos.lat, pos.lng);
            });
        }
        coordPreview.textContent = lat.toFixed(7) + ', ' + lng.toFixed(7);
    }

    function closeMap() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('btn-open-map').addEventListener('click', openMap);
    document.getElementById('btn-open-map-2').addEventListener('click', openMap);
    document.getElementById('btn-close-map').addEventListener('click', closeMap);

    document.getElementById('btn-confirm-coord').addEventListener('click', function () {
        if (!tempCoord) return;
        inputLat.value = tempCoord.lat.toFixed(7);
        inputLng.value = tempCoord.lng.toFixed(7);
        displayLat.textContent = tempCoord.lat.toFixed(7);
        displayLng.textContent = tempCoord.lng.toFixed(7);
        closeMap();
    });
})();
</script>
@endpush