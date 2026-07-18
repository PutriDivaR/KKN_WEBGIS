<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RumahAdat;
use App\Models\Suku;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MapController extends Controller
{
    /**
     * GET /peta
     * Daftar suku diambil dari tabel `suku` asli untuk mengisi filter sidebar.
     */
    public function index(): View
    {
        $sukuList = Suku::orderBy('nama_suku')->get(['id_suku', 'nama_suku']);

        return view('pages.map', compact('sukuList'));
    }

    /**
     * GET /peta/data
     * Dipanggil lewat fetch() dari map.blade.php untuk mengisi marker Leaflet.
     * Query string yang didukung:
     *   ?status=dihuni|kosong        (single)
     *   ?suku[]=1&suku[]=3           (bisa lebih dari satu — checkbox)
     *   ?search=kata kunci
     *
     * Rumah tanpa latitude/longitude (masih ada beberapa di data survei)
     * otomatis tidak diikutkan karena memang tidak bisa dipetakan.
     */
    public function data(Request $request): JsonResponse
    {
        $query = RumahAdat::query()
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
                $query->where('id_status', $idStatus);
            }
        }

        // Filter suku: multi-select (checkbox). Kosong / tidak dikirim = semua suku.
        $sukuIds = array_filter((array) $request->query('suku', []));
        if (! empty($sukuIds)) {
            $query->whereIn('id_suku', $sukuIds);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_rumah', 'like', "%{$search}%")
                    ->orWhere('nomor_rumah', 'like', "%{$search}%")
                    ->orWhereHas('suku', fn ($sq) => $sq->where('nama_suku', 'like', "%{$search}%"));
            });
        }

        $rumah = $query->get()->map(fn (RumahAdat $r) => [
            'id'       => $r->id_rumah,
            'nama'     => $r->nama_tampil,
            'suku'     => $r->suku_label,
            'status'   => $r->status_key,
            'kategori' => $r->kategori_label,
            'lat'      => $r->latitude,
            'lng'      => $r->longitude,
            'foto'     => $r->foto_utama,
        ]);

        return response()->json([
            'rumah_adat' => $rumah->values(),
            // Tabel `fasilitas_wisata` belum punya kolom koordinat di DB,
            // jadi layer fasilitas untuk sementara dikosongkan dulu di peta
            // (checkbox-nya juga sudah dinonaktifkan di map.blade.php).
            'fasilitas'  => [],
        ]);
    }
}
