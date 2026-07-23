<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jorong;
use App\Models\MediaRumah;
use App\Models\RumahAdat;
use App\Models\SejarahRumah;
use App\Models\Suku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminRumahController extends Controller
{

	public function index(Request $request): View
	{
		$sukuList = Suku::query()->orderBy('nama_suku')->get(['id_suku', 'nama_suku']);
		$statusList = $this->statusOptions();

		$query = RumahAdat::query()->with(['suku', 'jorong', 'sejarah', 'media']);

		if ($search = trim((string) $request->query('search', ''))) {
			$query->where(function ($builder) use ($search) {
				$builder->where('nama_rumah', 'like', '%' . $search . '%')
					->orWhere('alamat_rumah', 'like', '%' . $search . '%')
					->orWhere('nomor_rumah', 'like', '%' . $search . '%')
					->orWhere('ninik_mamak', 'like', '%' . $search . '%');
			});
		}

		if ($sukuId = $request->query('suku')) {
			$query->where('id_suku', (int) $sukuId);
		}

		if ($statusId = $request->query('status')) {
			$query->where('id_status', (int) $statusId);
		}

		$rumah = $query->orderByDesc('id_rumah')->paginate(6);
		$rumah->getCollection()->transform(fn (RumahAdat $item) => $this->mapRumahCard($item));

		return view('admin.rumah.index', [
			'rumah' => $rumah,
			'sukuList' => $sukuList,
			'statusList' => $statusList,
			'filters' => [
				'search' => $search ?? '',
				'suku' => $request->query('suku', ''),
				'status' => $request->query('status', ''),
			],
		]);
	}

	public function create(): View
	{
		return view('admin.rumah.create', [
			'form' => $this->defaultFormValues(),
			'jorongList' => Jorong::orderBy('nama_jorong')->get(),
			'sukuList' => Suku::orderBy('nama_suku')->get(),
			'statusList' => $this->statusOptions(),
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $this->validateForm($request);

		DB::transaction(function () use ($validated, $request) {

			$rumah = new RumahAdat();

			$rumah->id_rumah = ((int) RumahAdat::max('id_rumah')) + 1;

			$rumah->id_kampung = 1;

			$rumah->nomor_rumah = str_pad($rumah->id_rumah,2,'0',STR_PAD_LEFT);

			$this->fillRumah($rumah,$validated);

			$rumah->save();

			$this->syncSejarah(
				$rumah->id_rumah,
				$validated['sejarah'] ?? null
			);

			$this->syncGaleri(
				$rumah->id_rumah,
				$request
			);

			$this->syncVideo(
				$rumah->id_rumah,
				$request
			);

		});

		return redirect()
			->route('admin.rumah.index')
			->with('status','Rumah adat berhasil ditambahkan.');
	}

	public function edit(string $rumah): View
{
    $rumah = RumahAdat::with([
        'sejarah',
        'media'
    ])->findOrFail($rumah);

    return view('admin.rumah.edit', [
        'rumahId' => $rumah->id_rumah,
        'form' => $this->formValuesFromModel($rumah),
        'jorongList' => Jorong::orderBy('nama_jorong')->get(),
        'sukuList' => Suku::orderBy('nama_suku')->get(),
        'statusList' => $this->statusOptions(),
    ]);
}

	public function show(string $rumah): View
	{
		$rumah = RumahAdat::with([
			'suku',
			'jorong',
			'sejarah',
			'media',
		])->findOrFail($rumah);

		return view('admin.rumah.show', [
			'rumah' => $rumah,
		]);
	}

	public function update(Request $request,string $rumah): RedirectResponse
	{
		$validated=$this->validateForm($request);

		$rumah=RumahAdat::findOrFail($rumah);

		DB::transaction(function() use($rumah,$validated,$request){

			$this->fillRumah($rumah,$validated);

			$rumah->save();

			$this->syncSejarah(
				$rumah->id_rumah,
				$validated['sejarah'] ?? null
			);

			$this->syncGaleri(
				$rumah->id_rumah,
				$request
			);

			$this->syncVideo(
				$rumah->id_rumah,
				$request
			);

		});

		return redirect()
			->route('admin.rumah.index')
			->with('status','Rumah berhasil diperbarui.');
	}

	public function destroy(string $rumah): RedirectResponse
	{
		$rumahModel = RumahAdat::findOrFail($rumah);

		DB::transaction(function () use ($rumahModel) {
			MediaRumah::where('id_rumah', $rumahModel->id_rumah)->get()->each(function (MediaRumah $media) {
				Storage::disk('public')->delete($media->file);
			});

			MediaRumah::where('id_rumah', $rumahModel->id_rumah)->delete();
			SejarahRumah::where('id_rumah', $rumahModel->id_rumah)->delete();
			$rumahModel->delete();
		});

		return redirect()->route('admin.rumah.index')->with('status', 'Rumah adat berhasil dihapus.');
	}

	private function defaultFormValues(): array
	{
		return [
			'nama' => '',
			'jorong_id' => '',
			'status_id' => 1,
			'suku_id' => '',
			'tahun_dibangun' => '',
			'alamat' => '',
			'sejarah' => '',
			'video_judul' => '',
			'latitude' => '-0.637812',
			'longitude' => '100.809123',
		];
	}

	private function formValuesFromModel(RumahAdat $rumah): array
{
    return [
        'nama' => $rumah->nama_rumah ?? '',
        'jorong_id' => $rumah->id_jorong ?? '',
        'status_id' => $rumah->id_status ?? 1,
        'suku_id' => $rumah->id_suku ?? '',
        'tahun_dibangun' => $rumah->tahun_dibangun ?? '',
        'alamat' => $rumah->alamat_rumah ?? '',
        'sejarah' => optional($rumah->sejarah)->sejarah,
        'video_judul' => optional(
            $rumah->media->firstWhere('jenis_media','video')
        )->nama_file,

        'latitude' => $rumah->latitude,
        'longitude' => $rumah->longitude,

        // tambahkan ini
        'gallery' => $rumah->media
            ->where('jenis_media','foto')
            ->values(),

        'video' => $rumah->media
            ->firstWhere('jenis_media','video'),
    ];
}

	private function validateForm(Request $request): array
	{
		return $request->validate([
			'nama' => ['required', 'string', 'max:150'],
			'jorong_id' => ['required', 'integer', 'exists:jorong,id_jorong'],
			'suku_id' => ['required', 'integer', 'exists:suku,id_suku'],
			'status_id' => ['required', 'integer', 'in:1,2'],
			'tahun_dibangun' => ['nullable', 'string', 'max:100'],
			'alamat' => ['nullable', 'string'],
			'sejarah' => ['nullable', 'string'],
			'latitude' => ['nullable', 'numeric'],
			'longitude' => ['nullable', 'numeric'],
			'galeri' => ['nullable', 'array'],
			'galeri.*' => ['file', 'image', 'max:5120'],
			'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/x-matroska,video/quicktime', 'max:51200'],
		]);
	}

	private function fillRumah(RumahAdat $rumah, array $validated): void
	{
		$rumah->id_suku = (int) $validated['suku_id'];
		$rumah->id_jorong = (int) $validated['jorong_id'];
		$rumah->id_status = (int) $validated['status_id'];
		$rumah->nama_rumah = $validated['nama'];
		$rumah->alamat_rumah = $validated['alamat'] ?: null;
		$rumah->tahun_dibangun = $validated['tahun_dibangun'] ?: null;
		$rumah->latitude = $validated['latitude'] ?? null;
		$rumah->longitude = $validated['longitude'] ?? null;
	}

	private function syncSejarah(int $rumahId, ?string $sejarah): void
	{
		if (! filled($sejarah)) {
			return;
		}

		SejarahRumah::updateOrCreate([
			'id_rumah' => $rumahId,
		], [
			'sejarah' => $sejarah,
		]);
	}

	private function syncGaleri(int $rumahId, Request $request): void
	{
		if (!$request->hasFile('galeri')) {
			return;
		}

		$lama = MediaRumah::where('id_rumah',$rumahId)
			->where('jenis_media','foto')
			->get();

		foreach ($lama as $media) {

			Storage::disk('public')->delete($media->file);

			$media->delete();
		}

		foreach ($request->file('galeri') as $file) {

			$path = $file->store('rumah-adat','public');

			MediaRumah::create([
				'id_rumah'=>$rumahId,
				'nama_file'=>$file->getClientOriginalName(),
				'file'=>$path,
				'jenis_media'=>'foto',
			]);
		}
	}

	private function syncVideo(int $rumahId, Request $request): void
	{
		if (! $request->hasFile('video_file')) {
			return;
		}

		MediaRumah::where('id_rumah', $rumahId)->where('jenis_media', 'video')->delete();

		$file = $request->file('video_file');
		$path = $file->store('rumah-adat', 'public');

		MediaRumah::create([
			'id_rumah' => $rumahId,
			'nama_file' => $request->input('video_judul') ?: $file->getClientOriginalName(),
			'file' => $path,
			'jenis_media' => 'video',
		]);
	}

	private function statusOptions(): array
	{
		return [
			['value' => 1, 'label' => 'Aktif Dihuni'],
			['value' => 2, 'label' => 'Kosong'],
		];
	}

	private function mapRumahCard(RumahAdat $rumah): array
	{
		return [
			'id' => $rumah->id_rumah,
			'nama' => $rumah->nama_tampil,
			'suku' => $rumah->suku_label,
			'status' => $rumah->status_key,
			'lokasi' => $rumah->jorong_label !== 'Belum diketahui' ? 'Jorong ' . $rumah->jorong_label : $rumah->alamat_label,
			'updated_at' => 'No. ' . ($rumah->nomor_rumah ?? str_pad((string) $rumah->id_rumah, 2, '0', STR_PAD_LEFT)),
		];
	}
}
