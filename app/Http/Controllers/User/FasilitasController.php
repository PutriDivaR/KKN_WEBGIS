<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FasilitasWisata;
use Illuminate\Support\Str;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = FasilitasWisata::with(['media', 'jorong'])
            ->orderBy('nama')
            ->get()
            ->map(function (FasilitasWisata $item) {
                // Foto lebih diutamakan tampil duluan di galeri modal
                $media = $item->media
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
                    'id'         => $item->id_fasilitas,
                    'nama'       => $item->nama,
                    'kategori'   => $item->kategori ?: 'Umum',
                    'jorong'     => optional($item->jorong)->nama_jorong,
                    'deskripsi'  => $item->deskripsi,
                    'ringkasan'  => $item->deskripsi ? Str::limit($item->deskripsi, 110) : null,
                    'latitude'   => $item->latitude,
                    'longitude'  => $item->longitude,
                    'thumbnail'  => $thumbnail,
                    'media'      => $media,
                ];
            });

        return view('pages.fasilitas', compact('fasilitas'));
    }
}