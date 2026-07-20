<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Budaya;
use Illuminate\View\View;

class TentangController extends Controller
{
    /**
     * GET /tentang
     *
     * Tab "Budaya" sudah terhubung ke tabel `budaya` (id_budaya, nama, deskripsi).
     * Tab "Tentang Kampung Adat" masih dummy — tabel `kampung_adat` di DB masih
     * kosong, jadi belum ada yang bisa di-query dari sana.
     * Tab "Dokumentasi Kampung Adat" sengaja full dummy/placeholder — isinya
     */
    public function index(): View
    {
        $tentang = [
            'isi_sejarah' => 'Kampung Adat Sijunjung merupakan kawasan permukiman tradisional yang masih terjaga keaslian budaya, arsitektur, dan nilai-nilai masyarakat Minangkabau.',
            'paragraf_dua' => 'Kawasan ini telah menjadi bagian penting dari sejarah panjang peradaban di Kabupaten Sijunjung dan menjadi identitas budaya yang diwariskan secara turun-temurun.',
            'lokasi' => 'Muaro Sijunjung, Kabupaten Sijunjung, Sumatera Barat',
            'status_kawasan' => 'Kawasan Cagar Budaya',
            'masyarakat' => 'Suku Melayu, Bodi, Piliang, Tobo, dan lainnya',
        ];

        $budayaList = Budaya::orderBy('nama')->get();

        return view('pages.tentang', compact('tentang', 'budayaList'));
    }
}
