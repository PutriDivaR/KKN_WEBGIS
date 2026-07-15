<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = [

            [
                'nama' => 'Masjid Kampung',
                'kategori' => 'Ibadah',
                'deskripsi' => 'Tempat ibadah utama masyarakat Kampung Adat Sijunjung.',
                'gambar' => '',
                'warna' => 'green',
            ],

            [
                'nama' => 'Balai Adat',
                'kategori' => 'Budaya',
                'deskripsi' => 'Tempat penyelenggaraan musyawarah adat dan kegiatan budaya.',
                'gambar' => '',
                'warna' => 'orange',
            ],

            [
                'nama' => 'Sekretariat Adat',
                'kategori' => 'Administrasi',
                'deskripsi' => 'Pusat administrasi dan pengelolaan kawasan Kampung Adat.',
                'gambar' => '',
                'warna' => 'blue',
            ],

            [
                'nama' => 'Balai Nikah',
                'kategori' => 'Pelayanan',
                'deskripsi' => 'Tempat pelaksanaan akad nikah dan kegiatan adat lainnya.',
                'gambar' => '',
                'warna' => 'red',
            ],

            [
                'nama' => 'Lapangan',
                'kategori' => 'Umum',
                'deskripsi' => 'Digunakan untuk berbagai aktivitas masyarakat dan acara adat.',
                'gambar' => '',
                'warna' => 'purple',
            ],

        ];

        return view(
            'pages.fasilitas',
            compact('fasilitas')
        );
    }
}