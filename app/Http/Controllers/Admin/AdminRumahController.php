<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class AdminRumahController extends Controller
{
	public function index(Request $request): View
	{
		$sukuList = ['Semua Suku', 'Bodi', 'Panai', 'Piliang', 'Tobo', 'Chaniago', 'Melayu'];
		$statusList = ['Semua Status', 'dihuni', 'kosong'];

		$rumah = collect($this->dummyRumah());

		if ($search = trim((string) $request->query('search', ''))) {
			$rumah = $rumah->filter(fn ($item) => str_contains(mb_strtolower($item['nama']), mb_strtolower($search)));
		}

		if ($suku = $request->query('suku')) {
			$rumah = $rumah->filter(fn ($item) => $suku === 'Semua Suku' || $item['suku'] === $suku);
		}

		if ($status = $request->query('status')) {
			$rumah = $rumah->filter(fn ($item) => $status === 'Semua Status' || $item['status'] === $status);
		}

		$page = LengthAwarePaginator::resolveCurrentPage();
		$perPage = 6;
		$items = $rumah->values();

		$paginated = new LengthAwarePaginator(
			$items->slice(($page - 1) * $perPage, $perPage)->values(),
			$items->count(),
			$perPage,
			$page,
			[
				'path' => $request->url(),
				'query' => $request->query(),
			]
		);

		return view('admin.rumah.index', [
			'rumah' => $paginated,
			'sukuList' => $sukuList,
			'statusList' => $statusList,
			'filters' => [
				'search' => $search ?? '',
				'suku' => $request->query('suku', 'Semua Suku'),
				'status' => $request->query('status', 'Semua Status'),
			],
		]);
	}

	public function create(): View
	{
		return view('admin.rumah.create');
	}

	public function store(Request $request): \Illuminate\Http\RedirectResponse
	{
		return redirect()->route('admin.rumah.index');
	}

	public function show(string $rumah): \Illuminate\Http\RedirectResponse
	{
		return redirect()->route('admin.rumah.index');
	}

	public function edit(string $rumah): View
	{
		return view('admin.rumah.edit');
	}

	public function update(Request $request, string $rumah): \Illuminate\Http\RedirectResponse
	{
		return redirect()->route('admin.rumah.index');
	}

	public function destroy(string $rumah): \Illuminate\Http\RedirectResponse
	{
		return redirect()->route('admin.rumah.index');
	}

	private function dummyRumah(): array
	{
		return [
			['id' => 1, 'nama' => 'Rumah Gadang Dt. Sinaro', 'suku' => 'Piliang', 'status' => 'dihuni', 'lokasi' => 'Jorong Sijunjung', 'foto' => '', 'updated_at' => '2 jam lalu'],
			['id' => 2, 'nama' => 'Rumah Gadang Dt. Mudo', 'suku' => 'Piliang', 'status' => 'dihuni', 'lokasi' => 'Jorong Sijunjung', 'foto' => '', 'updated_at' => '3 jam lalu'],
			['id' => 3, 'nama' => 'Rumah Gadang Dt. Rajo', 'suku' => 'Bodi', 'status' => 'kosong', 'lokasi' => 'Jorong Sijunjung', 'foto' => '', 'updated_at' => '5 jam lalu'],
			['id' => 4, 'nama' => 'Rumah Gadang Dt. Sampono', 'suku' => 'Chaniago', 'status' => 'dihuni', 'lokasi' => 'Jorong Sijunjung', 'foto' => '', 'updated_at' => '1 hari lalu'],
			['id' => 5, 'nama' => 'Rumah Gadang Dt. Bandaro', 'suku' => 'Tobo', 'status' => 'kosong', 'lokasi' => 'Jorong Sijunjung', 'foto' => '', 'updated_at' => '1 hari lalu'],
			['id' => 6, 'nama' => 'Rumah Gadang Dt. Penghulu', 'suku' => 'Melayu', 'status' => 'dihuni', 'lokasi' => 'Jorong Sijunjung', 'foto' => '', 'updated_at' => '2 hari lalu'],
			['id' => 7, 'nama' => 'Rumah Gadang Piliang Tuo', 'suku' => 'Piliang', 'status' => 'kosong', 'lokasi' => 'Jorong Sijunjung', 'foto' => '', 'updated_at' => '3 hari lalu'],
			['id' => 8, 'nama' => 'Rumah Gadang Chaniago Sati', 'suku' => 'Chaniago', 'status' => 'dihuni', 'lokasi' => 'Jorong Sijunjung', 'foto' => '', 'updated_at' => '4 hari lalu'],
		];
	}
}
