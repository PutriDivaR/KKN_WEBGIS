/**
 * public/js/peta.js
 * Dipakai oleh resources/views/pages/map.blade.php
 * Butuh window.PETA_CONFIG = { dataUrl, rumahBaseUrl, center, zoom } yang
 * di-set lewat inline <script> sebelum file ini di-load.
 */
document.addEventListener('DOMContentLoaded', function () {
    const config = window.PETA_CONFIG || {};
    const ICON_HOME = 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25';

    const map = L.map('leaflet-map', { zoomControl: false }).setView(config.center || [-0.708, 100.9855], config.zoom || 16);
    L.control.zoom({ position: 'topright' }).addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    const markersLayer = L.layerGroup().addTo(map);

    function pinIcon(status) {
        // status: 'dihuni' | 'kosong' | 'unknown'
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

    function buildPopup(item) {
        const tpl = document.getElementById('popup-template').content.cloneNode(true);
        const wrap = document.createElement('div');
        wrap.appendChild(tpl);

        const fotoEl = wrap.querySelector('[data-role="foto"]');
        fotoEl.src = item.foto || '';
        fotoEl.alt = item.nama;

        wrap.querySelector('[data-role="nama"]').textContent = item.nama;
        wrap.querySelector('[data-role="suku-row"]').textContent = 'Suku: ' + (item.suku || 'Belum diketahui');

        const statusText = item.status === 'dihuni' ? 'Aktif Dihuni' : (item.status === 'kosong' ? 'Kosong' : 'Belum diketahui');
        wrap.querySelector('[data-role="status-row"]').textContent = 'Status: ' + statusText;
        wrap.querySelector('[data-role="kategori-row"]').textContent = 'Kategori: ' + (item.kategori || 'Belum dikategorikan');
        wrap.querySelector('[data-role="link"]').href = `${config.rumahBaseUrl}/${item.id}`;

        return wrap.innerHTML;
    }

    function render(data) {
        markersLayer.clearLayers();

        const showRumah = document.getElementById('filter-rumah').checked;
        if (!showRumah) return;

        (data.rumah_adat || []).forEach(item => {
            L.marker([item.lat, item.lng], { icon: pinIcon(item.status) })
                .bindPopup(buildPopup(item))
                .addTo(markersLayer);
        });

        // Layer fasilitas belum aktif (checkbox disabled) karena tabel
        // fasilitas_wisata di DB belum punya kolom koordinat.
    }

    function fetchAndRender() {
        const status = document.querySelector('input[name="status-rumah"]:checked')?.value || '';
        const suku = document.querySelector('input[name="filter-suku"]:checked')?.value || '';
        const search = document.getElementById('map-search').value || '';

        const params = new URLSearchParams();
        if (status) params.set('status', status);
        if (suku) params.set('suku', suku);
        if (search) params.set('search', search);

        fetch(`${config.dataUrl}?${params.toString()}`)
            .then(res => res.json())
            .then(render)
            .catch(err => console.error('Gagal memuat data peta:', err));
    }

    document.getElementById('filter-rumah').addEventListener('change', fetchAndRender);
    document.querySelectorAll('input[name="status-rumah"]').forEach(el => el.addEventListener('change', fetchAndRender));
    document.querySelectorAll('input[name="filter-suku"]').forEach(el => el.addEventListener('change', fetchAndRender));

    let searchTimer;
    document.getElementById('map-search').addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(fetchAndRender, 300);
    });

    document.getElementById('reset-filter').addEventListener('click', function () {
        document.getElementById('filter-rumah').checked = true;
        document.querySelector('input[name="status-rumah"][value=""]').checked = true;
        document.querySelector('input[name="filter-suku"][value=""]').checked = true;
        document.getElementById('map-search').value = '';
        fetchAndRender();
    });

    fetchAndRender();
});
