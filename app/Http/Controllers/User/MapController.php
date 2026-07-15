<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MapController extends Controller
{
    /**
     * GET /peta
     * Menampilkan halaman peta. Daftar suku dikirim untuk mengisi filter sidebar.
     */
    public function index(): View
    {
        $sukuList = ['Bodi', 'Panai', 'Piliang', 'Tobo', 'Chaniago', 'Melayu'];

        return view('pages.map', compact('sukuList'));
    }

    /**
     * GET /peta/data
     * Dipanggil lewat fetch() dari map.blade.php untuk mengisi marker Leaflet.
     * Mendukung filter opsional lewat query string:
     *   ?status=dihuni|kosong   ?suku=Piliang   ?search=kata kunci
     *
     * NOTE: Ini masih data dummy hardcode. Begitu tabel `rumah_adat` &
     * `fasilitas` sudah ada di DB kkn_webgis, ganti $this->dummyRumahAdat()
     * dan $this->dummyFasilitas() dengan query Eloquent, misal:
     *   RumahAdat::with('suku')->when($request->status, fn ($q, $s) => $q->where('status', $s))->get();
     */
    public function data(Request $request): JsonResponse
    {
        $rumah = collect($this->dummyRumahAdat());
        $fasilitas = collect($this->dummyFasilitas());

        if ($status = $request->query('status')) {
            $rumah = $rumah->where('status', $status);
        }

        if ($suku = $request->query('suku')) {
            $rumah = $rumah->where('suku', $suku);
        }

        if ($search = $request->query('search')) {
            $search = mb_strtolower($search);
            $rumah = $rumah->filter(
                fn ($item) => str_contains(mb_strtolower($item['nama']), $search)
                    || str_contains(mb_strtolower($item['suku']), $search)
            );
            $fasilitas = $fasilitas->filter(
                fn ($item) => str_contains(mb_strtolower($item['nama']), $search)
            );
        }

        return response()->json([
            'rumah_adat' => $rumah->values(),
            'fasilitas'  => $fasilitas->values(),
        ]);
    }

    private function dummyRumahAdat(): array
    {
        return [
            ['id' => 1, 'nama' => 'Rumah Gadang Dt. Sinaro',   'suku' => 'Piliang',  'status' => 'dihuni', 'kategori' => 'Rumah Gadang', 'lat' => -0.6360, 'lng' => 100.8110, 'foto' => ''],
            ['id' => 2, 'nama' => 'Rumah Gadang Dt. Rajo Malano', 'suku' => 'Chaniago', 'status' => 'dihuni', 'kategori' => 'Rumah Gadang', 'lat' => -0.6395, 'lng' => 100.8065, 'foto' => ''],
            ['id' => 3, 'nama' => 'Rumah Gadang Bodi Caniago',  'suku' => 'Bodi',     'status' => 'kosong', 'kategori' => 'Rumah Gadang', 'lat' => -0.6320, 'lng' => 100.8055, 'foto' => ''],
            ['id' => 4, 'nama' => 'Rumah Gadang Dt. Panai',     'suku' => 'Panai',    'status' => 'dihuni', 'kategori' => 'Rumah Gadang', 'lat' => -0.6345, 'lng' => 100.8145, 'foto' => ''],
            ['id' => 5, 'nama' => 'Rumah Gadang Tobo Indah',    'suku' => 'Tobo',     'status' => 'kosong', 'kategori' => 'Rumah Gadang', 'lat' => -0.6410, 'lng' => 100.8130, 'foto' => ''],
            ['id' => 6, 'nama' => 'Rumah Gadang Dt. Melayu',    'suku' => 'Melayu',   'status' => 'dihuni', 'kategori' => 'Rumah Gadang', 'lat' => -0.6375, 'lng' => 100.8095, 'foto' => ''],
            ['id' => 7, 'nama' => 'Rumah Gadang Piliang Tuo',   'suku' => 'Piliang',  'status' => 'kosong', 'kategori' => 'Rumah Gadang', 'lat' => -0.6300, 'lng' => 100.8100, 'foto' => ''],
            ['id' => 8, 'nama' => 'Rumah Gadang Chaniago Sati', 'suku' => 'Chaniago', 'status' => 'dihuni', 'kategori' => 'Rumah Gadang', 'lat' => -0.6425, 'lng' => 100.8080, 'foto' => ''],
        ];
    }

    private function dummyFasilitas(): array
    {
        return [
            ['id' => 1, 'nama' => 'Musala Kampung',  'kategori' => 'Ibadah',    'lat' => -0.6365, 'lng' => 100.8120, 'foto' => ''],
            ['id' => 2, 'nama' => 'Balai Adat',       'kategori' => 'Budaya',    'lat' => -0.6350, 'lng' => 100.8070, 'foto' => ''],
            ['id' => 3, 'nama' => 'Lumbung Padi',     'kategori' => 'Pertanian', 'lat' => -0.6390, 'lng' => 100.8140, 'foto' => ''],
            ['id' => 4, 'nama' => 'Pusat Informasi',  'kategori' => 'Umum',      'lat' => -0.6335, 'lng' => 100.8090, 'foto' => ''],
        ];
    }
}