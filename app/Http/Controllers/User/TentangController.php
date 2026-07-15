<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class TentangController extends Controller
{
    public function index()
    {
        $tentang = [

            'judul_sejarah' => 'Sejarah Kampung Adat Sijunjung',

            'isi_sejarah' =>
                'Kampung Adat Sijunjung telah berdiri sejak abad ke-19 dan menjadi salah satu kawasan permukiman adat Minangkabau yang masih mempertahankan nilai-nilai tradisional hingga saat ini.',

            'judul_budaya' => 'Nilai Budaya',

            'isi_budaya' =>
                'Sistem kekerabatan matrilineal, arsitektur rumah gadang, dan musyawarah adat masih dijalankan secara turun-temurun oleh masyarakat setempat.',

            'struktur' => [

                [
                    'nama' => 'Datuk Penghulu',
                    'peran' => 'Pemimpin adat tertinggi'
                ],

                [
                    'nama' => 'Bundo Kanduang',
                    'peran' => 'Pemangku adat perempuan'
                ],

                [
                    'nama' => 'Malin',
                    'peran' => 'Pemuka agama kampung'
                ],

            ]

        ];

        return view(
            'pages.tentang',
            compact('tentang')
        );
    }
}