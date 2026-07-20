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
     * Daftar suku diambil dari tabel `suku` asli untuk mengisi filter sidebar.
     */
    public function index(): View
    {
        $sukuList = Suku::orderBy('nama_suku')->get(['id_suku', 'nama_suku']);
        $kategoriFasilitasList = self::KATEGORI_FASILITAS;

        return view('pages.map', compact('sukuList', 'kategoriFasilitasList'));
    }

    /**
     * GET /peta/data
     * Dipanggil lewat fetch() dari map.blade.php untuk mengisi marker Leaflet.
     * Query string yang didukung:
     *   ?status=dihuni|kosong                (single, khusus rumah adat)
     *   ?suku[]=1&suku[]=3                   (bisa lebih dari satu — checkbox)
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

        // Filter suku: multi-select (checkbox). Kosong / tidak dikirim = semua suku.
        $sukuIds = array_filter((array) $request->query('suku', []));
        if (! empty($sukuIds)) {
            $rumahQuery->whereIn('id_suku', $sukuIds);
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