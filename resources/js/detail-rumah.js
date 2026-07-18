/**
 * public/js/detail-rumah.js
 * Dipakai oleh resources/views/pages/detailrumah.blade.php
 * Butuh window.RUMAH_LOKASI = { lat, lng } yang di-set lewat inline
 * <script> sebelum file ini di-load. Hanya dimuat kalau rumah punya
 * koordinat (lihat kondisi @if($rumah->has_lokasi) di blade-nya).
 */
let lokasiMap;

function initLokasiMap() {
    if (lokasiMap || !window.RUMAH_LOKASI) return;

    const { lat, lng } = window.RUMAH_LOKASI;

    lokasiMap = L.map('lokasi-map', {
        zoomControl: false,
        dragging: false,
        scrollWheelZoom: false,
    }).setView([lat, lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(lokasiMap);

    L.marker([lat, lng]).addTo(lokasiMap);
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
