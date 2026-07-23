<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FasilitasWisata;
use App\Models\RumahAdat;
use App\Models\Suku;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MapController extends Controller
{
    /**
     * Daftar kategori fasilitas untuk isi checkbox filter di sidebar.
     * Disamakan dengan enum kolom `kategori` pada tabel fasilitas_wisata.
     * Fasilitas dengan kategori NULL di DB ditampilkan sebagai "Umum".
     */
    private const KATEGORI_FASILITAS = ['Pendidikan', 'Pusat Informasi', 'Umum'];

    /**
     * GET /peta
     * Filter suku di sidebar sekarang memakai 6 kelompok suku resmi
     * (Suku::GROUPS), bukan lagi 14 baris mentah dari tabel `suku`.
     * Bentuk objek (id_suku, nama_suku) sengaja dipertahankan sama seperti
     * sebelumnya supaya blade filter tidak perlu diubah — hanya isinya
     * yang sekarang nama kelompok, bukan id per-varian.
     */
    public function index(): View
    {
        $sukuList = collect(Suku::GROUPS)->map(fn (string $group) => (object) [
            'id_suku'   => $group,
            'nama_suku' => $group,
        ])->values();

        $kategoriFasilitasList = self::KATEGORI_FASILITAS;

        return view('pages.map', compact('sukuList', 'kategoriFasilitasList'));
    }

    /**
     * GET /peta/data
     * Dipanggil lewat fetch() dari map.blade.php untuk mengisi marker Leaflet.
     * Query string yang didukung:
     *   ?status=dihuni|kosong                (single, khusus rumah adat)
     *   ?suku[]=Chaniago&suku[]=Piliang      (nama kelompok — bisa lebih dari satu)
     *   ?kategori_fasilitas[]=Pendidikan      (bisa lebih dari satu — checkbox)
     *   ?search=kata kunci                    (dipakai untuk rumah & fasilitas)
     *
     * Baris/rumah atau fasilitas tanpa latitude/longitude otomatis tidak
     * diikutkan karena memang tidak bisa dipetakan.
     */
    public function data(Request $request): JsonResponse
    {
        $search = $request->query('search');

        // -------- Rumah Adat --------
        $rumahQuery = RumahAdat::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with(['suku', 'kategori']);

        if ($status = $request->query('status')) {
            $idStatus = match ($status) {
                'dihuni' => 1,
                'kosong' => 2,
                default => null,
            };
            if ($idStatus) {
                $rumahQuery->where('id_status', $idStatus);
            }
        }

        // Filter suku: sekarang berupa nama KELOMPOK (mis. "Chaniago"), bukan
        // id_suku mentah. Diterjemahkan dulu ke semua nama_suku asli yang
        // termasuk kelompok itu (bisa lebih dari satu varian per kelompok)
        // sebelum dipakai untuk query. Kosong / tidak dikirim = semua suku.
        $sukuGroups = array_filter((array) $request->query('suku', []));
        if (! empty($sukuGroups)) {
            $rawNames = collect($sukuGroups)
                ->flatMap(fn (string $group) => Suku::namesInGroup($group))
                ->unique()
                ->values()
                ->all();

            $rumahQuery->whereHas('suku', fn ($sq) => $sq->whereIn('nama_suku', $rawNames));
        }

        if ($search) {
            $rumahQuery->where(function ($q) use ($search) {
                $q->where('nama_rumah', 'like', "%{$search}%")
                    ->orWhere('nomor_rumah', 'like', "%{$search}%")
                    ->orWhereHas('suku', fn ($sq) => $sq->where('nama_suku', 'like', "%{$search}%"));
            });
        }

        $rumah = $rumahQuery->get()->map(fn (RumahAdat $r) => [
            'id'       => $r->id_rumah,
            'nama'     => $r->nama_tampil,
            'suku'     => $r->suku_label,
            'status'   => $r->status_key,
            'kategori' => $r->kategori_label,
            'lat'      => $r->latitude,
            'lng'      => $r->longitude,
            'foto'     => $r->foto_utama,
        ]);

        // -------- Fasilitas --------
        $fasilitasQuery = FasilitasWisata::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with(['media', 'jorong']);

        // Filter kategori fasilitas: multi-select (checkbox). Kosong = semua kategori.
        $kategoriFasilitas = array_filter((array) $request->query('kategori_fasilitas', []));
        if (! empty($kategoriFasilitas)) {
            $fasilitasQuery->where(function ($q) use ($kategoriFasilitas) {
                $q->whereIn('kategori', $kategoriFasilitas);
                // "Umum" dipakai juga untuk menampung baris yang kategorinya NULL di DB.
                if (in_array('Umum', $kategoriFasilitas, true)) {
                    $q->orWhereNull('kategori');
                }
            });
        }

        if ($search) {
            $fasilitasQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $fasilitas = $fasilitasQuery->get()->map(function (FasilitasWisata $f) {
            $media = $f->media
                ->sortBy(fn ($m) => $m->jenis_media === 'foto' ? 0 : 1)
                ->values()
                ->map(fn ($m) => [
                    'id'    => $m->id_medfas,
                    'nama'  => $m->nama_file ?: $m->file,
                    'jenis' => $m->jenis_media,
                    'url'   => $m->url,
                ]);

            $thumbnail = optional($media->firstWhere('jenis', 'foto'))['url'] ?? null;

            return [
                'id'        => $f->id_fasilitas,
                'nama'      => $f->nama,
                'kategori'  => $f->kategori ?: 'Umum',
                'jorong'    => optional($f->jorong)->nama_jorong,
                'deskripsi' => $f->deskripsi,
                'lat'       => $f->latitude,
                'lng'       => $f->longitude,
                'foto'      => $thumbnail,
                'media'     => $media,
            ];
        });

        return response()->json([
            'rumah_adat' => $rumah->values(),
            'fasilitas'  => $fasilitas->values(),
        ]);
    }
}