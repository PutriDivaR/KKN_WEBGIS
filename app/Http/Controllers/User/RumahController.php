<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\View\View;

class RumahController extends Controller
{
    /**
     * GET /rumah/{id}
     *
     * NOTE: masih data dummy hardcode, id dicocokkan manual di $this->dummyData().
     * Begitu tabel `rumah_adat` sudah ada, ganti jadi:
     *   $rumah = RumahAdat::with(['galeri', 'suku'])->findOrFail($id);
     * dan idealnya id di sini otomatis sinkron dengan id di MapController
     * karena sama-sama datang dari tabel yang sama.
     */
    public function show(int $id): View
    {
        $rumah = collect($this->dummyData())->firstWhere('id', $id)
            ?? $this->dummyData()[0];

        return view('pages.detailrumah', compact('rumah'));
    }

    private function dummyData(): array
    {
        return [
            [
                'id'               => 1,
                'nama'             => 'Rumah Gadang Dt. Sinaro',
                'status'           => 'dihuni',
                'suku'             => 'Piliang',
                'kategori'         => 'Rumah Gadang',
                'alamat'           => 'Jorong Sijunjung, Kampung Adat Sijunjung',
                'tahun_dibangun'   => '± 1850',
                'pemilik'          => 'Dt. Sinaro',
                'ninik_mamak'      => 'Dt. Sinaro',
                'jumlah_penghuni'  => '8 Orang',
                'jumlah_kk'        => '2 KK',
                'lat'              => -0.6360,
                'lng'              => 100.8110,
                'koordinat'        => '0.637012 LS, 100.809123 BT',
                'sejarah'          => 'Rumah Gadang Dt. Sinaro dibangun secara gotong royong oleh kaum Piliang dan telah beberapa kali direnovasi tanpa mengubah bentuk aslinya. Rumah ini menjadi saksi berbagai musyawarah adat penting di Kampung Adat Sijunjung.',
                'foto'             => '',
                'galeri'           => ['Tampak Depan.jpg', 'Tampak Samping.jpg', 'Atap Gonjong.jpg', 'Ukiran Dinding.jpg'],
                'video'            => '',
            ],
            [
                'id'               => 2,
                'nama'             => 'Rumah Gadang Dt. Rajo Malano',
                'status'           => 'dihuni',
                'suku'             => 'Chaniago',
                'kategori'         => 'Rumah Gadang',
                'alamat'           => 'Jorong Sijunjung, Kampung Adat Sijunjung',
                'tahun_dibangun'   => '± 1875',
                'pemilik'          => 'Dt. Rajo Malano',
                'ninik_mamak'      => 'Dt. Rajo Malano',
                'jumlah_penghuni'  => '6 Orang',
                'jumlah_kk'        => '1 KK',
                'lat'              => -0.6395,
                'lng'              => 100.8065,
                'koordinat'        => '0.639500 LS, 100.806500 BT',
                'sejarah'          => 'Rumah ini diwariskan turun-temurun dalam kaum Chaniago dan masih digunakan untuk acara adat besar.',
                'foto'             => '',
                'galeri'           => ['Tampak Depan.jpg', 'Halaman Rumah.jpg'],
                'video'            => '',
            ],
        ];
    }
}