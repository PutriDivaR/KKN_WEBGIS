<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
	public function index(Request $request): View
	{
		$search = trim((string) $request->query('search', ''));
		$searchLower = mb_strtolower($search);

		$stats = [
			['label' => 'Total Rumah Adat', 'value' => 76, 'badge' => '+2.4%', 'icon' => 'bi-house-door'],
			['label' => 'Masih Dihuni', 'value' => 58, 'badge' => 'Dihuni', 'icon' => 'bi-people'],
			['label' => 'Rumah Kosong', 'value' => 18, 'badge' => 'Kosong', 'icon' => 'bi-door-closed'],
			['label' => 'Total Fasilitas', 'value' => 5, 'badge' => 'Publik', 'icon' => 'bi-building'],
			['label' => 'Suku Terdata', 'value' => 6, 'badge' => 'Lengkap', 'icon' => 'bi-diagram-3'],
		];

		$mapSummary = [
			['label' => 'Rumah Adat', 'count' => 76, 'color' => 'bg-[#0b6a38]'],
			['label' => 'Rumah Kosong', 'count' => 18, 'color' => 'bg-[#cf6f42]'],
			['label' => 'Fasilitas', 'count' => 5, 'color' => 'bg-[#284b63]'],
		];

		$activities = [
			['title' => 'Rumah Gadang Dt. Sinaro diperbarui', 'time' => '2 jam lalu oleh Uda Sinaro', 'icon' => 'bi-pencil-square'],
			['title' => 'Foto baru ditambahkan pada Rumah Gadang Dt. Mudo', 'time' => '3 jam lalu oleh Budi Santoso', 'icon' => 'bi-image'],
			['title' => 'Video diperbarui pada Rumah Gadang Dt. Rajo', 'time' => '5 jam lalu', 'icon' => 'bi-camera-video'],
			['title' => 'Fasilitas Masjid Raya ditambahkan', 'time' => '1 hari lalu', 'icon' => 'bi-building-add'],
		];

		$latestCards = [
			['name' => 'Rumah Gadang Dt. Sinaro', 'meta' => 'Piliang · Terdaftar 28 Mei 2024', 'status' => 'TERKINI', 'image' => asset('assets/wallpaper_beranda.jpeg'), 'image_position' => 'center 20%', 'route' => route('admin.rumah.index'), 'type' => 'rumah'],
			['name' => 'Balai Adat Sijunjung', 'meta' => 'Fasilitas · Terdaftar 28 Mei 2024', 'status' => 'TERKINI', 'image' => asset('assets/siteplan(dummy).png'), 'image_position' => 'center center', 'route' => route('admin.fasilitas.index'), 'type' => 'fasilitas'],
			['name' => 'Sekretariat Adat', 'meta' => 'Gubernur · Terdaftar 27 Mei 2024', 'status' => 'TERKINI', 'image' => asset('assets/wallpaper_beranda.jpeg'), 'image_position' => 'center 55%', 'route' => route('admin.fasilitas.index'), 'type' => 'fasilitas'],
		];

		if ($search !== '') {
			$latestCards = array_values(array_filter($latestCards, function (array $card) use ($searchLower): bool {
				$haystack = mb_strtolower($card['name'] . ' ' . $card['meta'] . ' ' . $card['type']);

				return str_contains($haystack, $searchLower);
			}));

			$activities = array_values(array_filter($activities, function (array $activity) use ($searchLower): bool {
				$haystack = mb_strtolower($activity['title'] . ' ' . $activity['time']);

				return str_contains($haystack, $searchLower);
			}));
		}

		return view('admin.dashboard', compact('stats', 'mapSummary', 'activities', 'latestCards', 'search'));
	}
}
