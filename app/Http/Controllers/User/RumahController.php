<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RumahAdat;
use Illuminate\View\View;

class RumahController extends Controller
{
    /**
     * GET /rumah/{id}
     * id di sini adalah id_rumah asli dari tabel rumah_adat (bukan urutan
     * 1,2,3,... — beberapa nomor memang tidak ada / dilewati di data survei).
     */
    public function show(int $id): View
    {
        $rumah = RumahAdat::with(['suku', 'jorong', 'pemilik', 'penghuni', 'sejarah', 'media', 'kategori'])
            ->findOrFail($id);

        return view('pages.detailrumah', compact('rumah'));
    }
}
