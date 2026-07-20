<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jorong;
use App\Models\MediaRumah;
use App\Models\RumahAdatDraft;
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
	private const CREATE_SESSION_KEY = 'admin_rumah_wizard.create';

	private function editSessionKey(string $rumahId): string
	{
		return 'admin_rumah_wizard.edit.' . $rumahId;
	}

	public function index(Request $request): View
	{
		$sukuList = Suku::query()->orderBy('nama_suku')->get(['id_suku', 'nama_suku']);
		$statusList = $this->statusOptions();
		$drafts = RumahAdatDraft::query()->orderByDesc('updated_at')->get();

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
			'drafts' => $drafts,
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
		$step = $this->currentStep(request()->query('step', 1));
		$wizardData = session(self::CREATE_SESSION_KEY, $this->defaultFormValues());
		$draftId = request()->query('draft_id');

		if ($draftId) {
			$draft = RumahAdatDraft::find($draftId);

			if ($draft) {
				$wizardData = array_merge($this->defaultFormValues(), $draft->payload ?? []);
				$step = $this->currentStep(request()->query('step', $draft->step_current));
			}
		}

		return view('admin.rumah.create', $this->formData($wizardData, $step, $draftId ? (int) $draftId : null));
	}

	public function store(Request $request): RedirectResponse
	{
		$step = $this->currentStep($request->input('step', 1));
		$sessionKey = self::CREATE_SESSION_KEY;
		$wizardData = session($sessionKey, $this->defaultFormValues());
		$draftId = $request->input('draft_id');

		if ($request->input('wizard_action') === 'draft') {
			return $this->saveDraft($request, $sessionKey, $step, null, 'admin.rumah.create', $draftId);
		}

		if ($step === 1) {
			$validated = $request->validate([
				'nama' => ['required', 'string', 'max:150'],
				'jorong_id' => ['required', 'integer', 'exists:jorong,id_jorong'],
				'suku_id' => ['required', 'integer', 'exists:suku,id_suku'],
				'status_id' => ['required', 'integer', 'in:1,2'],
				'tahun_dibangun' => ['nullable', 'string', 'max:100'],
				'alamat' => ['nullable', 'string'],
				'latitude' => ['nullable', 'numeric'],
				'longitude' => ['nullable', 'numeric'],
			]);

			$wizardData = array_merge($wizardData, $validated);
			session([$sessionKey => $wizardData]);

			return redirect()->route('admin.rumah.create', ['step' => 2]);
		}

		if ($step === 2) {
			$validated = $request->validate([
				'sejarah' => ['required', 'string'],
			]);

			$wizardData = array_merge($wizardData, $validated);
			session([$sessionKey => $wizardData]);

			return redirect()->route('admin.rumah.create', ['step' => 3]);
		}

		if ($step === 3) {
			$validated = $request->validate([
				'galeri' => ['required', 'array', 'min:1'],
				'galeri.*' => ['file', 'image', 'max:5120'],
			]);

			$wizardData['gallery_pending'] = $this->storeTempFiles($request->file('galeri'), 'rumah-adat/temp/gallery');
			session([$sessionKey => $wizardData]);

			return redirect()->route('admin.rumah.create', ['step' => 4]);
		}

		if ($step === 4) {
			$request->validate([
				'video_judul' => ['required', 'string', 'max:150'],
				'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/x-matroska,video/quicktime', 'max:51200'],
			]);

			$wizardData['video_judul'] = $request->input('video_judul');
			if ($request->hasFile('video_file')) {
				$wizardData['video_pending'] = $this->storeTempFile($request->file('video_file'), 'rumah-adat/temp/video');
			}
			session([$sessionKey => $wizardData]);

			return redirect()->route('admin.rumah.create', ['step' => 5]);
		}

		if (! $request->boolean('confirm_publish')) {
			return back()->withErrors(['confirm_publish' => 'Centang konfirmasi sebelum menyimpan data.']);
		}

		$rumah = DB::transaction(function () use ($wizardData) {
			$rumah = new RumahAdat();
			$rumah->id_rumah = ((int) DB::table('rumah_adat')->max('id_rumah')) + 1;
			$rumah->id_kampung = 1;
			$rumah->nomor_rumah = str_pad((string) $rumah->id_rumah, 2, '0', STR_PAD_LEFT);
			$this->fillRumah($rumah, $wizardData);
			$rumah->save();

			$this->syncSejarah($rumah->id_rumah, $wizardData['sejarah'] ?? null);
			$this->syncPendingGallery($rumah->id_rumah, $wizardData['gallery_pending'] ?? []);
			$this->syncPendingVideo($rumah->id_rumah, $wizardData['video_pending'] ?? null, $wizardData['video_judul'] ?? null);

			return $rumah;
		});

		session()->forget($sessionKey);

		return redirect()->route('admin.rumah.edit', ['rumah' => $rumah->id_rumah, 'step' => 5])->with('status', 'Rumah adat berhasil disimpan.');
	}

	public function show(string $rumah): View
	{
		$rumahData = RumahAdat::with(['suku', 'jorong', 'pemilik', 'sejarah', 'media', 'kategori', 'kondisi', 'penghuni'])->findOrFail($rumah);

		return view('admin.rumah.show', [
			'rumah' => $rumahData,
		]);
	}

	public function edit(string $rumah): View
	{
		$step = $this->currentStep(request()->query('step', 1));
		$data = RumahAdat::with(['suku', 'jorong', 'sejarah', 'media'])->findOrFail($rumah);
		$wizardData = session($this->editSessionKey($data->id_rumah), $this->formValuesFromModel($data));

		return view('admin.rumah.edit', array_merge($this->formData(), [
			'rumahId' => $data->id_rumah,
			'currentStep' => $step,
			'form' => $wizardData,
		]));
	}

	public function update(Request $request, string $rumah): RedirectResponse
	{
		$rumahModel = RumahAdat::findOrFail($rumah);
		$sessionKey = $this->editSessionKey($rumahModel->id_rumah);
		$wizardData = session($sessionKey, $this->formValuesFromModel($rumahModel));
		$step = $this->currentStep($request->input('step', 1));
		$draftId = $request->input('draft_id');

		if ($request->input('wizard_action') === 'draft') {
			return $this->saveDraft($request, $sessionKey, $step, $rumahModel, 'admin.rumah.edit', $draftId);
		}

		if ($step === 1) {
			$validated = $request->validate([
				'nama' => ['required', 'string', 'max:150'],
				'jorong_id' => ['required', 'integer', 'exists:jorong,id_jorong'],
				'suku_id' => ['required', 'integer', 'exists:suku,id_suku'],
				'status_id' => ['required', 'integer', 'in:1,2'],
				'tahun_dibangun' => ['nullable', 'string', 'max:100'],
				'alamat' => ['nullable', 'string'],
				'latitude' => ['nullable', 'numeric'],
				'longitude' => ['nullable', 'numeric'],
			]);

			$wizardData = array_merge($wizardData, $validated);
			session([$sessionKey => $wizardData]);

			return redirect()->route('admin.rumah.edit', ['rumah' => $rumahModel->id_rumah, 'step' => 2]);
		}

		if ($step === 2) {
			$validated = $request->validate([
				'sejarah' => ['required', 'string'],
			]);

			$wizardData = array_merge($wizardData, $validated);
			session([$sessionKey => $wizardData]);

			return redirect()->route('admin.rumah.edit', ['rumah' => $rumahModel->id_rumah, 'step' => 3]);
		}

		if ($step === 3) {
			$request->validate([
				'galeri' => ['nullable', 'array'],
				'galeri.*' => ['file', 'image', 'max:5120'],
			]);

			if ($request->hasFile('galeri')) {
				$wizardData['gallery_pending'] = array_merge($wizardData['gallery_pending'] ?? [], $this->storeTempFiles($request->file('galeri'), 'rumah-adat/temp/gallery'));
			}

			session([$sessionKey => $wizardData]);

			return redirect()->route('admin.rumah.edit', ['rumah' => $rumahModel->id_rumah, 'step' => 4]);
		}

		if ($step === 4) {
			$request->validate([
				'video_judul' => ['required', 'string', 'max:150'],
				'video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/x-matroska,video/quicktime', 'max:51200'],
			]);

			$wizardData['video_judul'] = $request->input('video_judul');
			if ($request->hasFile('video_file')) {
				$wizardData['video_pending'] = $this->storeTempFile($request->file('video_file'), 'rumah-adat/temp/video');
			}
			session([$sessionKey => $wizardData]);

			return redirect()->route('admin.rumah.edit', ['rumah' => $rumahModel->id_rumah, 'step' => 5]);
		}

		if (! $request->boolean('confirm_publish')) {
			return back()->withErrors(['confirm_publish' => 'Centang konfirmasi sebelum menyimpan perubahan.']);
		}

		DB::transaction(function () use ($rumahModel, $wizardData) {
			$this->fillRumah($rumahModel, $wizardData);
			$rumahModel->save();

			$this->syncSejarah($rumahModel->id_rumah, $wizardData['sejarah'] ?? null);
			$this->syncPendingGallery($rumahModel->id_rumah, $wizardData['gallery_pending'] ?? []);
			$this->syncPendingVideo($rumahModel->id_rumah, $wizardData['video_pending'] ?? null, $wizardData['video_judul'] ?? null);
		});

		session()->forget($sessionKey);

		return redirect()->route('admin.rumah.edit', ['rumah' => $rumahModel->id_rumah, 'step' => 5])->with('status', 'Perubahan rumah adat berhasil disimpan.');
	}

	public function destroyDraft(string $draft): RedirectResponse
	{
		RumahAdatDraft::where('id_draft', $draft)->delete();

		return redirect()->route('admin.rumah.index')->with('status', 'Draft dihapus.');
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

	private function formData(array $form = [], int $currentStep = 1, ?int $draftId = null): array
	{
		$stepTitles = [
			1 => ['label' => 'Informasi', 'next' => 'Sejarah'],
			2 => ['label' => 'Sejarah', 'next' => 'Galeri'],
			3 => ['label' => 'Galeri', 'next' => 'Video'],
			4 => ['label' => 'Video', 'next' => 'Konfirmasi'],
			5 => ['label' => 'Konfirmasi', 'next' => null],
		];

		return [
			'sukuList' => Suku::query()->orderBy('nama_suku')->get(['id_suku', 'nama_suku']),
			'jorongList' => Jorong::query()->orderBy('nama_jorong')->get(['id_jorong', 'nama_jorong']),
			'statusList' => $this->statusOptions(),
			'form' => array_merge($this->defaultFormValues(), $form),
			'currentStep' => $currentStep,
			'stepTitles' => $stepTitles,
			'draftId' => $draftId,
		];
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
			'sejarah' => $rumah->sejarah->sejarah ?? '',
			'video_judul' => optional($rumah->media->firstWhere('jenis_media', 'video'))->nama_file ?? '',
			'latitude' => $rumah->latitude,
			'longitude' => $rumah->longitude,
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
		if (! $request->hasFile('galeri')) {
			return;
		}

		foreach ($request->file('galeri') as $file) {
			if (! $file) {
				continue;
			}

			$path = $file->store('rumah-adat', 'public');

			MediaRumah::create([
				'id_rumah' => $rumahId,
				'nama_file' => $file->getClientOriginalName(),
				'file' => $path,
				'jenis_media' => 'foto',
			]);
		}
	}

	private function syncPendingGallery(int $rumahId, array $files): void
	{
		foreach ($files as $fileData) {
			MediaRumah::create([
				'id_rumah' => $rumahId,
				'nama_file' => $fileData['name'],
				'file' => $fileData['path'],
				'jenis_media' => 'foto',
			]);
		}
	}

	private function syncPendingVideo(int $rumahId, ?array $fileData, ?string $judul): void
	{
		if (! $fileData) {
			return;
		}

		MediaRumah::where('id_rumah', $rumahId)->where('jenis_media', 'video')->delete();

		MediaRumah::create([
			'id_rumah' => $rumahId,
			'nama_file' => $judul ?: $fileData['name'],
			'file' => $fileData['path'],
			'jenis_media' => 'video',
		]);
	}

	private function storeTempFiles(array $files, string $directory): array
	{
		$stored = [];

		foreach ($files as $file) {
			$stored[] = [
				'name' => $file->getClientOriginalName(),
				'path' => $file->store($directory, 'public'),
			];
		}

		return $stored;
	}

	private function storeTempFile($file, string $directory): array
	{
		return [
			'name' => $file->getClientOriginalName(),
			'path' => $file->store($directory, 'public'),
		];
	}

	private function currentStep(int|string $step): int
	{
		$step = (int) $step;

		return max(1, min(5, $step));
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

	private function saveDraft(Request $request, string $sessionKey, int $step, ?RumahAdat $rumah = null, string $routeName = 'admin.rumah.create', ?string $draftId = null): RedirectResponse
	{
		$wizardData = session($sessionKey, $rumah ? $this->formValuesFromModel($rumah) : $this->defaultFormValues());

		$wizardData = array_merge($wizardData, array_filter($request->only([
			'nama',
			'jorong_id',
			'status_id',
			'suku_id',
			'tahun_dibangun',
			'alamat',
			'sejarah',
			'video_judul',
			'latitude',
			'longitude',
		]), static fn ($value) => ! is_null($value) && $value !== ''));

		if ($request->hasFile('galeri')) {
			$wizardData['gallery_pending'] = array_merge($wizardData['gallery_pending'] ?? [], $this->storeTempFiles($request->file('galeri'), 'rumah-adat/temp/gallery'));
		}

		if ($request->hasFile('video_file')) {
			$wizardData['video_pending'] = $this->storeTempFile($request->file('video_file'), 'rumah-adat/temp/video');
		}

		$draft = RumahAdatDraft::updateOrCreate(
			['id_draft' => $draftId],
			[
				'judul' => $wizardData['nama'] ?: 'Draft Rumah Adat',
				'step_current' => $step,
				'payload' => $wizardData,
			]
		);

		$wizardData['draft_id'] = $draft->id_draft;

		session([$sessionKey => $wizardData]);

		$routeParams = $rumah
			? ['rumah' => $rumah->id_rumah, 'step' => $step]
			: ['step' => $step];
		$routeParams['draft_id'] = $draft->id_draft;

		return redirect()->route($routeName, $routeParams)->with('status', 'Draft tersimpan.');
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
