<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class PerancanganController extends Controller
{
    /**
     * Mapping slug (dipakai di URL & data teks) ke nama folder ASLI
     * yang sudah ada di public/assets/perancangan/.
     *
     * Ini perlu karena nama folder di disk (commercial, gate, parking,
     * tugu, dst.) tidak selalu sama persis dengan slug yang dipakai
     * di data teks (area-parkir, gate-kawasan, pusat-komersial, ...).
     *
     * Kalau nanti ada perancangan baru, tinggal tambah 1 baris di sini
     * + 1 folder baru di public/assets/perancangan/.
     */
    private const FOLDER_MAP = [
        'area-parkir'     => 'parking',
        'gate-kawasan'    => 'gate',
        'pusat-komersial' => 'commercial',
        'tugu-kawasan'    => 'tugu',
        'streetscape'     => 'streetscape',
    ];

    /**
     * Ekstensi file yang dianggap video / gambar saat proses scan folder.
     */
    private const VIDEO_EXTENSIONS = ['mp4', 'webm', 'mov', 'ogg'];
    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    /**
     * Override manual: gambar mana yang dipakai sebagai foto utama
     * (slide ke-2, sebelah video) untuk slug tertentu. Kalau slug
     * tidak ada di sini (atau file yang disebut ternyata tidak ada di
     * folder), sistem otomatis fallback ke gambar pertama secara abjad.
     *
     * Nama file HARUS persis sama (case-sensitive) dengan yang ada
     * di folder public/assets/perancangan/{folder}/.
     */
    private const MAIN_IMAGE_OVERRIDE = [
        'gate-kawasan' => 'desain2.png',
    ];

    public function index(): View
    {
        return view('pages.perancangan', ['items' => $this->dummyData()]);
    }

    /**
     * GET /perancangan/{slug}
     */
    public function show(string $slug): View
    {
        $all  = $this->dummyData();
        $item = collect($all)->firstWhere('slug', $slug) ?? $all[0];

        return view('pages.detailperancangan', ['item' => $item, 'allItems' => $all]);
    }

    /**
     * Data teks tetap statis (dummy) karena memang tidak akan sering
     * berubah. Yang dinamis hanya bagian media (video_3d, foto_utama,
     * galeri) -> di-resolve otomatis lewat resolveAssets().
     */
    private function dummyData(): array
    {
        $items = [
            [
                'id'        => 1,
                'slug'      => 'area-parkir',
                'nama'      => 'Area Parkir',
                'legenda'   => 'Area Parkir',
                'warna'     => 'blue',
                'icon'      => 'parkir',
                'posisi_top'  => 45,
                'posisi_left' => 22,
                'ringkasan' => 'Area parkir terpusat untuk pengunjung kawasan Kampung Adat.',
                'narasi'    => 'Area parkir dirancang dengan kapasitas kendaraan roda dua dan roda empat, dilengkapi peneduh pohon dan jalur pejalan kaki menuju gerbang utama.',
                'fungsi'    => 'Fasilitas Penunjang',
                'luas_area' => '± 800 m²',
                'material'  => 'Paving Block, Aspal',
                'konsep'    => 'Ramah Lingkungan',
            ],
            [
                'id'        => 2,
                'slug'      => 'gate-kawasan',
                'nama'      => 'Gate Kawasan',
                'legenda'   => 'Gate Kawasan',
                'warna'     => 'green',
                'icon'      => 'home',
                'posisi_top'  => 22,
                'posisi_left' => 28,
                'ringkasan' => 'Gerbang utama sebagai identitas masuk ke kawasan Kampung Adat.',
                'narasi'    => 'Rencana gerbang utama dirancang mengangkat elemen arsitektur tradisional Minangkabau agar selaras dengan karakter kawasan. Bentuk atap gonjong dipertahankan sebagai penanda visual, dipadukan dengan struktur modern untuk kekuatan dan efisiensi konstruksi.',
                'fungsi'    => 'Identitas & Orientasi',
                'luas_area' => '± 250 m²',
                'material'  => 'Kayu, Batu Alam',
                'konsep'    => 'Tradisional Modern',
            ],
            [
                'id'        => 3,
                'slug'      => 'pusat-komersial',
                'nama'      => 'Pusat Komersial',
                'legenda'   => 'Pusat Komersial',
                'warna'     => 'orange',
                'icon'      => 'komersial',
                'posisi_top'  => 42,
                'posisi_left' => 44,
                'ringkasan' => 'Kawasan komersial pendukung ekonomi masyarakat sekitar Kampung Adat.',
                'narasi'    => 'Pusat komersial menampung kios UMKM dan produk kerajinan lokal, dirancang menyatu dengan lanskap kawasan tanpa menghilangkan nuansa adat.',
                'fungsi'    => 'Ekonomi & UMKM',
                'luas_area' => '± 600 m²',
                'material'  => 'Kayu, Bata Ekspos',
                'konsep'    => 'Kontemporer Vernakular',
            ],
            [
                'id'        => 4,
                'slug'      => 'tugu-kawasan',
                'nama'      => 'Tugu Kawasan',
                'legenda'   => 'Tugu Kawasan',
                'warna'     => 'red',
                'icon'      => 'tugu',
                'posisi_top'  => 38,
                'posisi_left' => 62,
                'ringkasan' => 'Tugu penanda sekaligus ikon visual kawasan Kampung Adat Sijunjung.',
                'narasi'    => 'Tugu dirancang sebagai landmark kawasan, mengangkat filosofi adat Minangkabau lewat bentuk dan ukiran pada permukaannya.',
                'fungsi'    => 'Landmark Kawasan',
                'luas_area' => '± 100 m²',
                'material'  => 'Batu Andesit, Beton',
                'konsep'    => 'Simbolis Tradisional',
            ],
            [
                'id'        => 5,
                'slug'      => 'streetscape',
                'nama'      => 'Streetscape',
                'legenda'   => 'Streetscape',
                'warna'     => 'purple',
                'icon'      => 'streetscape',
                'posisi_top'  => 65,
                'posisi_left' => 55,
                'ringkasan' => 'Penataan jalur pedestrian dan lanskap jalan utama kawasan.',
                'narasi'    => 'Streetscape mencakup penataan trotoar, penerangan jalan bertema tradisional, dan jalur hijau untuk kenyamanan pejalan kaki di sepanjang kawasan.',
                'fungsi'    => 'Sirkulasi & Kenyamanan',
                'luas_area' => '± 1.200 m',
                'material'  => 'Paving, Tanaman Peneduh',
                'konsep'    => 'Walkable Heritage Street',
            ],
        ];

        return array_map(fn ($item) => $this->resolveAssets($item), $items);
    }

    /**
     * Scan folder asli di public/assets/perancangan/{folder} dan ambil
     * otomatis 1 video (untuk slide utama) + semua gambar yang ada
     * (gambar pertama dipakai juga sebagai foto_utama/poster, sisanya
     * jadi galeri render).
     *
     * Kalau folder/file belum ada, field media di-set null / array
     * kosong -> blade sudah handle kondisi ini dengan aman.
     */
    private function resolveAssets(array $item): array
    {
        $folder      = self::FOLDER_MAP[$item['slug']] ?? $item['slug'];
        $relativeDir = 'assets/perancangan/' . $folder;
        $absoluteDir = public_path($relativeDir);

        $video  = null;
        $images = [];

        if (File::isDirectory($absoluteDir)) {
            $files = File::files($absoluteDir);

            // urutkan biar konsisten (desain1, desain2, desain3, ...)
            usort($files, fn ($a, $b) => strnatcasecmp($a->getFilename(), $b->getFilename()));

            foreach ($files as $file) {
                $ext = strtolower($file->getExtension());

                if ($video === null && in_array($ext, self::VIDEO_EXTENSIONS, true)) {
                    $video = $file->getFilename();
                    continue;
                }

                if (in_array($ext, self::IMAGE_EXTENSIONS, true)) {
                    $images[] = $file->getFilename();
                }
            }
        }

        $override = self::MAIN_IMAGE_OVERRIDE[$item['slug']] ?? null;
        $mainImage = null;

        if ($override) {
            $overrideName = pathinfo($override, PATHINFO_FILENAME);
            foreach ($images as $img) {
                if (strcasecmp($img, $override) === 0 || strcasecmp(pathinfo($img, PATHINFO_FILENAME), $overrideName) === 0) {
                    $mainImage = $img;
                    break;
                }
            }
        }

        if ($mainImage === null && $images) {
            $mainImage = $images[0];
        }

        $item['video_3d']   = $video ? asset($relativeDir . '/' . $video) : null;
        $item['foto_utama']  = $mainImage ? asset($relativeDir . '/' . $mainImage) : null;

        $item['galeri'] = array_map(fn (string $file) => [
            'nama' => $file,
            'src'  => asset($relativeDir . '/' . $file),
        ], $images);

        return $item;
    }
}