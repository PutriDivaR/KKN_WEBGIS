<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminTentangController extends Controller
{
	public function index(): View
	{
		$sections = [
			['label' => 'Profil Kampung', 'icon' => 'bi-info-circle'],
			['label' => 'Sejarah', 'icon' => 'bi-book'],
			['label' => 'Tim Pengembang', 'icon' => 'bi-people'],
			['label' => 'Kontak', 'icon' => 'bi-chat-dots'],
		];

		return view('admin.tentang.index', compact('sections'));
	}
}
