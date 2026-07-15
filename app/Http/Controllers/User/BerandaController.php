<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $stats = [
            [
                'value' => 76,
                'label' => 'Rumah Adat'
            ],
            [
                'value' => 6,
                'label' => 'Suku'
            ],
            [
                'value' => 5,
                'label' => 'Fasilitas'
            ],
            [
                'value' => 1,
                'label' => 'Kampung Adat'
            ],
        ];

        $infoCards = [

            [
                'title' => 'Rumah Adat',
                'desc' => 'Jelajahi berbagai rumah adat beserta informasi lengkap mengenai sejarah, suku, dan lokasi.',
                'url' => route('map'),
            ],

            [
                'title' => 'Sejarah Kampung',
                'desc' => 'Pelajari sejarah Kampung Adat Sijunjung sebagai salah satu kawasan cagar budaya Minangkabau.',
                'url' => route('tentang'),
            ],

            [
                'title' => 'Fasilitas',
                'desc' => 'Temukan berbagai fasilitas yang tersedia untuk mendukung aktivitas masyarakat dan wisatawan.',
                'url' => route('fasilitas.index'),
            ],

        ];

        $gallery = [

            [
                'name' => 'Rumah Gadang 1',
                'image' => ''
            ],

            [
                'name' => 'Rumah Gadang 2',
                'image' => ''
            ],

            [
                'name' => 'Interior',
                'image' => ''
            ],

            [
                'name' => 'Lingkungan',
                'image' => ''
            ],

            [
                'name' => 'Rumah Gadang 3',
                'image' => ''
            ],

            [
                'name' => 'Rumah Gadang 4',
                'image' => ''
            ],

        ];

        return view(
            'pages.home',
            compact(
                'stats',
                'infoCards',
                'gallery'
            )
        );
    }
}