<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminAktivitasController extends Controller
{
    public function index(): View
    {
        $activities = [
            ['title' => 'Rumah Gadang Dt. Sinaro diperbarui', 'time' => '2 jam lalu oleh Uda Sinaro', 'icon' => 'bi-pencil-square', 'category' => 'Rumah Adat', 'route' => route('admin.rumah.index')],
            ['title' => 'Foto baru ditambahkan pada Rumah Gadang Dt. Mudo', 'time' => '3 jam lalu oleh Budi Santoso', 'icon' => 'bi-image', 'category' => 'Rumah Adat', 'route' => route('admin.rumah.index')],
            ['title' => 'Video diperbarui pada Rumah Gadang Dt. Rajo', 'time' => '5 jam lalu', 'icon' => 'bi-camera-video', 'category' => 'Rumah Adat', 'route' => route('admin.rumah.index')],
            ['title' => 'Fasilitas Masjid Raya ditambahkan', 'time' => '1 hari lalu', 'icon' => 'bi-building-add', 'category' => 'Fasilitas', 'route' => route('admin.fasilitas.index')],
            ['title' => 'Balai Adat Sijunjung diperbarui', 'time' => '1 hari lalu', 'icon' => 'bi-pencil-square', 'category' => 'Fasilitas', 'route' => route('admin.fasilitas.index')],
            ['title' => 'Sekretariat Adat ditandai terkini', 'time' => '2 hari lalu', 'icon' => 'bi-bookmark-star', 'category' => 'Rumah Adat', 'route' => route('admin.rumah.index')],
        ];

        $summary = [
            ['label' => 'Total Aktivitas', 'value' => count($activities), 'icon' => 'bi-list-check'],
            ['label' => 'Rumah Adat', 'value' => 4, 'icon' => 'bi-house-door'],
            ['label' => 'Fasilitas', 'value' => 2, 'icon' => 'bi-building'],
        ];

        return view('admin.aktivitas.index', compact('activities', 'summary'));
    }
}