<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FasilitasWisata;
use App\Models\Jorong;
use App\Models\MediaFasilitas;
use App\Models\MediaRumah;
use App\Models\RumahAdat;
use App\Models\Suku;
use Illuminate\Support\Collection;

class BerandaController extends Controller
{
    /**
     * Jumlah foto yang ditampilkan di galeri beranda. Diambil acak dari
     * gabungan foto rumah adat + fasilitas setiap kali halaman dibuka.
     */
    private const JUMLAH_GALERI = 8;

    public function index()
    {
        $stats = [
            [
                'value' => RumahAdat::count(),
                'label' => 'Rumah Adat',
            ],
            [
                // Selalu 6 — jumlah kelompok suku resmi (lihat Suku::GROUPS),
                // bukan jumlah baris mentah di tabel suku (yang datanya 14
                // varian penulisan/sub-suku hasil survei).
                'value' => count(Suku::GROUPS),
                'label' => 'Suku',
            ],
            [
                'value' => FasilitasWisata::count(),
                'label' => 'Fasilitas',
            ],
            [
                'value' => Jorong::count(),
                'label' => 'Jorong',
            ],
        ];

        $infoCards = [
            [
                'title' => 'Rumah Adat',
                'desc'  => 'Jelajahi berbagai rumah adat beserta informasi lengkap mengenai sejarah, suku, dan lokasi.',
                'url'   => route('map'),
            ],
            [
                'title' => 'Sejarah Kampung',
                'desc'  => 'Pelajari sejarah Kampung Adat Sijunjung sebagai salah satu kawasan cagar budaya Minangkabau.',
                'url'   => route('tentang'),
            ],
            [
                'title' => 'Fasilitas',
                'desc'  => 'Temukan berbagai fasilitas yang tersedia untuk mendukung aktivitas masyarakat dan wisatawan.',
                'url'   => route('fasilitas.index'),
            ],
        ];

        $gallery = $this->randomGallery();

        return view('pages.home', compact('stats', 'infoCards', 'gallery'));
    }

    /**
     * Gabungkan semua foto (bukan video) yang pernah diunggah untuk rumah
     * adat (media_rumah) dan fasilitas (media_fasilitas), acak urutannya,
     * lalu ambil sejumlah JUMLAH_GALERI. Karena diacak per-request, galeri
     * beranda akan menampilkan kombinasi berbeda tiap kali di-refresh.
     */
    private function randomGallery(): Collection
    {
        $fotoRumah = MediaRumah::query()
            ->where('jenis_media', 'foto')
            ->with('rumah:id_rumah,nomor_rumah,nama_rumah')
            ->get()
            ->map(fn (MediaRumah $m) => [
                'name'  => $m->rumah
                    ? 'Rumah Gadang No. ' . $m->rumah->nomor_rumah
                    : ($m->nama_file ?: 'Rumah Adat'),
                'image' => $m->url,
            ]);

        $fotoFasilitas = MediaFasilitas::query()
            ->where('jenis_media', 'foto')
            ->with('fasilitas:id_fasilitas,nama')
            ->get()
            ->map(fn (MediaFasilitas $m) => [
                'name'  => optional($m->fasilitas)->nama ?: ($m->nama_file ?: 'Fasilitas'),
                'image' => $m->url,
            ]);

        return $fotoRumah
            ->concat($fotoFasilitas)
            ->filter(fn ($item) => $item['image'] !== '')
            ->shuffle()
            ->take(self::JUMLAH_GALERI)
            ->values();
    }
}