@php
	$stepItems = [
		['number' => 1, 'label' => 'Informasi', 'active' => $activeStep === 1, 'done' => $activeStep > 1],
		['number' => 2, 'label' => 'Sejarah', 'active' => $activeStep === 2, 'done' => $activeStep > 2],
		['number' => 3, 'label' => 'Galeri', 'active' => $activeStep === 3, 'done' => $activeStep > 3],
		['number' => 4, 'label' => 'Video', 'active' => $activeStep === 4, 'done' => $activeStep > 4],
		['number' => 5, 'label' => 'Konfirmasi', 'active' => $activeStep === 5, 'done' => false],
	];

	$inputClass = 'h-11 w-full rounded-xl border border-[#d7e1d6] bg-white px-4 text-sm text-[#132018] outline-none transition focus:border-[#6f9870] focus:ring-2 focus:ring-[#dbe8d8] placeholder:text-[#98a69b]';
	$textareaClass = 'min-h-36 w-full rounded-2xl border border-[#d7e1d6] bg-white px-4 py-3 text-sm text-[#132018] outline-none transition focus:border-[#6f9870] focus:ring-2 focus:ring-[#dbe8d8] placeholder:text-[#98a69b]';
	$form = $form ?? [];
	$sukuList = $sukuList ?? collect();
	$jorongList = $jorongList ?? collect();
	$statusList = $statusList ?? [];
	$draftId = $draftId ?? null;
	$pendingGallery = collect($form['gallery_pending'] ?? []);
	$pendingVideo = $form['video_pending'] ?? null;
	$nextStep = min(5, $currentStep + 1);
	$prevStep = max(1, $currentStep - 1);
	$baseRoute = $mode === 'edit' ? route('admin.rumah.edit', $rumahId) : route('admin.rumah.create');
	$currentValues = $form;
	$currentStepLabel = $stepTitles[$currentStep]['label'] ?? 'Informasi';
	$nextStepLabel = $stepTitles[$nextStep]['label'] ?? null;
@endphp

<div class="space-y-6">
	<section class="rounded-[32px] border border-black/5 bg-white p-4 sm:p-6 shadow-sm">
		<div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
			<div>
				<p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#6f7f72]">Tahap {{ $currentStep }} dari 5</p>
				<h2 class="mt-1 text-2xl font-semibold text-[#173d2c]">{{ $mode === 'edit' ? 'Ubah Rumah Adat' : 'Tambah Rumah Adat' }} - {{ $currentStepLabel }}</h2>
				<p class="mt-2 max-w-2xl text-sm leading-6 text-[#6f7f72]">
					{{ $currentStepLabel }} sedang dibuka. {{ $nextStepLabel ? 'Setelah ini lanjut ke ' . $nextStepLabel . '.' : 'Ini tahap terakhir sebelum data dikirim.' }}
				</p>
			</div>

			<div class="flex items-center gap-3 rounded-2xl border border-[#dfe8dd] bg-[#f7faf5] px-4 py-3 text-sm text-[#56715d]">
				<div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#e5f0e3] text-[#2f5a36]">
					<i class="bi bi-shield-check"></i>
				</div>
				<div>
					<p class="font-semibold text-[#173d2c]">Mode Admin</p>
					<p class="text-xs text-[#6f7f72]">Siap simpan draft atau lanjut publikasi</p>
				</div>
			</div>
		</div>

		<div class="mt-6 grid grid-cols-1 gap-4 xl:grid-cols-5">
			@foreach ($stepItems as $step)
				<div class="flex items-start gap-3 xl:flex-col xl:items-center">
					<div class="flex items-center gap-3 xl:w-full">
						<div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 text-sm font-semibold {{ $step['done'] ? 'border-[#2f5a36] bg-[#2f5a36] text-white' : ($step['active'] ? 'border-[#2f5a36] bg-white text-[#2f5a36]' : 'border-[#e1e7df] bg-[#f7f9f6] text-[#97a49a]') }}">
							@if ($step['done'])
								<i class="bi bi-check2"></i>
							@else
								{{ $step['number'] }}
							@endif
						</div>
						<div class="hidden h-px flex-1 bg-[#c8d7c7] xl:block"></div>
					</div>
					<div class="xl:text-center">
						<p class="text-xs font-semibold uppercase tracking-[0.22em] {{ $step['active'] ? 'text-[#2f5a36]' : 'text-[#9aa79d]' }}">{{ $step['label'] }}</p>
						<p class="mt-1 text-[11px] text-[#98a69b]">{{ $step['number'] === 1 ? 'Data dasar rumah' : ($step['number'] === 2 ? 'Narasi dan nilai sejarah' : ($step['number'] === 3 ? 'Dokumentasi foto' : ($step['number'] === 4 ? 'Video utama' : 'Tinjau dan kirim'))) }}</p>
					</div>
				</div>
			@endforeach
		</div>
	</section>

		<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6">
		@csrf
		@if ($method !== 'POST')
			@method($method)
		@endif
		<input type="hidden" name="step" value="{{ $currentStep }}">
			@if ($draftId)
				<input type="hidden" name="draft_id" value="{{ $draftId }}">
			@endif

		@if ($currentStep === 1)
			<section class="grid grid-cols-1 gap-6 xl:grid-cols-[1.35fr_0.95fr]">
				<div class="rounded-[30px] border border-black/5 bg-white p-5 sm:p-6 shadow-sm">
					<div class="flex items-center gap-3">
						<div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#e0f0e0] text-[#2f5a36]"><i class="bi bi-info-circle"></i></div>
						<div>
							<h3 class="text-xl font-semibold text-[#173d2c]">Informasi Rumah Adat</h3>
							<p class="text-sm text-[#6f7f72]">Isi identitas dasar rumah adat sebelum lanjut ke sejarah.</p>
						</div>
					</div>

					<div class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-2">
						<label class="space-y-2">
							<span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#627467]">Nama Rumah *</span>
							<input type="text" name="nama" value="{{ old('nama', $currentValues['nama'] ?? '') }}" placeholder="Contoh: Rumah Gadang Dt. Sinaro" class="{{ $inputClass }}">
						</label>
						<label class="space-y-2">
							<span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#627467]">Jorong</span>
							<select name="jorong_id" class="{{ $inputClass }}">
								<option value="">Pilih Jorong</option>
								@foreach ($jorongList as $jorong)
									<option value="{{ $jorong->id_jorong }}" @selected((string) old('jorong_id', $currentValues['jorong_id'] ?? '') === (string) $jorong->id_jorong)>{{ $jorong->nama_jorong }}</option>
								@endforeach
							</select>
						</label>

						<label class="space-y-2">
							<span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#627467]">Status *</span>
							<select name="status_id" class="{{ $inputClass }}">
								<option value="">Pilih Status</option>
								@foreach ($statusList as $status)
									<option value="{{ $status['value'] }}" @selected((string) old('status_id', $currentValues['status_id'] ?? '') === (string) $status['value'])>{{ $status['label'] }}</option>
								@endforeach
							</select>
						</label>
						<label class="space-y-2">
							<span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#627467]">Suku *</span>
							<select name="suku_id" class="{{ $inputClass }}">
								<option value="">Pilih Suku</option>
								@foreach ($sukuList as $suku)
									<option value="{{ $suku->id_suku }}" @selected((string) old('suku_id', $currentValues['suku_id'] ?? '') === (string) $suku->id_suku)>{{ $suku->nama_suku }}</option>
								@endforeach
							</select>
						</label>

						<label class="space-y-2 md:col-span-2">
							<span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#627467]">Tahun Dibangun</span>
							<input type="text" name="tahun_dibangun" value="{{ old('tahun_dibangun', $currentValues['tahun_dibangun'] ?? '') }}" placeholder="Contoh: 1850" class="{{ $inputClass }}">
						</label>

						<label class="space-y-2 md:col-span-2">
							<span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#627467]">Alamat Lengkap</span>
							<textarea name="alamat" rows="4" placeholder="Contoh: Jorong Sijunjung, Nagari Sijunjung, Kec. Sijunjung, Kabupaten Sijunjung" class="{{ $textareaClass }}">{{ old('alamat', $currentValues['alamat'] ?? '') }}</textarea>
						</label>
					</div>
				</div>

				<aside class="space-y-6">
					<div class="overflow-hidden rounded-[30px] border border-black/5 bg-white shadow-sm">
						<div class="border-b border-[#e5ece3] p-5">
							<div class="flex items-center gap-3">
								<div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#e0f0e0] text-[#2f5a36]"><i class="bi bi-geo-alt"></i></div>
								<div>
									<h3 class="text-xl font-semibold text-[#173d2c]">Lokasi Geografis</h3>
									<p class="text-sm text-[#6f7f72]">Pilih lokasi rumah adat pada peta.</p>
								</div>
							</div>
						</div>
						<div class="p-5">
							<div class="rounded-[22px] border border-[#d7e1d6] bg-[#e7efe2] p-4">
								<div class="rounded-[18px] min-h-64 bg-[linear-gradient(180deg,rgba(233,241,226,0.45),rgba(223,230,213,0.85)),linear-gradient(135deg,#c9d7b8,#9db58e)] flex items-center justify-center">
									<button type="button" class="rounded-full bg-[#2f5a36] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#2f5a36]/25">Pilih Lokasi di Peta</button>
								</div>
							</div>
							<div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
								<label class="space-y-2"><span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#627467]">Latitude</span><input type="text" name="latitude" value="{{ old('latitude', $currentValues['latitude'] ?? '') }}" class="{{ $inputClass }}"></label>
								<label class="space-y-2"><span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#627467]">Longitude</span><input type="text" name="longitude" value="{{ old('longitude', $currentValues['longitude'] ?? '') }}" class="{{ $inputClass }}"></label>
							</div>
						</div>
					</div>
				</aside>
			</section>
		@endif

		@if ($currentStep === 2)
			<section class="grid grid-cols-1 gap-6 xl:grid-cols-[1.35fr_0.95fr]">
				<div class="rounded-[30px] border border-black/5 bg-white p-5 sm:p-6 shadow-sm">
					<div class="flex items-center gap-3">
						<div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#e0f0e0] text-[#2f5a36]"><i class="bi bi-journal-text"></i></div>
						<div>
							<h3 class="text-xl font-semibold text-[#173d2c]">Sejarah Rumah Adat</h3>
							<p class="text-sm text-[#6f7f72]">Tulis narasi sejarah, asal-usul, dan filosofi yang relevan.</p>
						</div>
					</div>

					<div class="mt-5 rounded-2xl border border-[#dfe6dd] bg-[#f7f9fb] p-3">
						<div class="flex flex-wrap items-center gap-2 border-b border-[#dfe6dd] px-2 pb-3 text-sm text-[#425448]">
							<span class="rounded-lg bg-white px-2 py-1 font-semibold">B</span>
							<span class="rounded-lg bg-white px-2 py-1 font-semibold italic">I</span>
							<span class="rounded-lg bg-white px-2 py-1 underline">U</span>
						</div>
						<textarea name="sejarah" rows="14" class="mt-3 {{ $textareaClass }} min-h-80 border-0 bg-white" placeholder="Tuliskan narasi sejarah rumah adat di sini">{{ old('sejarah', $currentValues['sejarah'] ?? '') }}</textarea>
					</div>
				</div>

				<aside class="space-y-6">
					<div class="rounded-[30px] border border-[#1f593c] bg-[#0b442a] p-6 text-white shadow-sm">
						<h3 class="text-xl font-semibold">Panduan Pengisian</h3>
						<p class="mt-3 text-sm leading-6 text-white/70">Gunakan bahasa yang jelas dan masukkan informasi sejarah yang paling penting terlebih dulu.</p>
						<div class="mt-5 space-y-3 text-sm text-white/75">
							<p class="flex gap-2"><i class="bi bi-dot"></i>Tambahkan asal-usul rumah bila tersedia.</p>
							<p class="flex gap-2"><i class="bi bi-dot"></i>Sebutkan tokoh adat yang berkaitan.</p>
							<p class="flex gap-2"><i class="bi bi-dot"></i>Gunakan paragraf singkat agar mudah dibaca.</p>
						</div>
					</div>
					<div class="overflow-hidden rounded-[24px] border border-black/5 bg-[#edf3ff] p-5 shadow-sm">
						<p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#7a869c]">Statistik Konten</p>
						<div class="mt-4 grid grid-cols-2 gap-3">
							<div class="rounded-2xl bg-white/75 p-4"><p class="text-3xl font-semibold text-[#173d2c]">{{ $stats['kata'] ?? 420 }}</p><p class="mt-1 text-xs uppercase tracking-[0.16em] text-[#7a869c]">kata sejarah</p></div>
							<div class="rounded-2xl bg-white/75 p-4"><p class="text-3xl font-semibold text-[#173d2c]">{{ $stats['foto'] ?? 12 }}</p><p class="mt-1 text-xs uppercase tracking-[0.16em] text-[#7a869c]">foto terunggah</p></div>
						</div>
					</div>
				</aside>
			</section>
		@endif

		@if ($currentStep === 3)
			<section class="grid grid-cols-1 gap-6 xl:grid-cols-[1.35fr_0.95fr]">
				<div class="rounded-[30px] border border-black/5 bg-white p-5 sm:p-6 shadow-sm">
					<div class="flex items-center justify-between gap-4">
						<div>
							<h3 class="text-xl font-semibold text-[#173d2c]">Galeri Foto Rumah Adat</h3>
							<p class="text-sm text-[#6f7f72]">Unggah dokumentasi visual untuk profil rumah adat.</p>
						</div>
						<label for="galeri_files" class="inline-flex items-center gap-2 rounded-xl border border-[#8eb696] px-4 py-2 text-sm font-semibold text-[#2f5a36] hover:bg-[#eff6ed] cursor-pointer"><i class="bi bi-camera"></i>Tambah Foto</label>
					</div>
					<div class="mt-5 grid grid-cols-2 gap-4 lg:grid-cols-3" id="galleryPreviewGrid">
						@if ($pendingGallery->isNotEmpty())
							@foreach ($pendingGallery as $pendingPhoto)
								@php
									$pendingPhotoPath = is_array($pendingPhoto) ? ($pendingPhoto['path'] ?? '') : $pendingPhoto;
									$pendingPhotoName = is_array($pendingPhoto) ? ($pendingPhoto['name'] ?? basename($pendingPhotoPath)) : basename($pendingPhotoPath);
								@endphp
								<div class="overflow-hidden rounded-2xl border border-[#d7e1d6] bg-[#fbfcfa] shadow-sm">
									<div class="h-32 bg-[#eef2ec]">
										<img src="{{ asset('storage/' . $pendingPhotoPath) }}" alt="Foto draft" class="h-full w-full object-cover">
									</div>
									<div class="p-3">
										<p class="text-sm font-semibold text-[#132018] truncate">Draft foto tersimpan</p>
										<p class="mt-1 text-xs text-[#6f7f72]">{{ $pendingPhotoName }}</p>
									</div>
								</div>
							@endforeach
						@else
							<div class="col-span-full rounded-2xl border border-dashed border-[#b9d2be] bg-[#f8fbf7] p-8 text-center text-[#5d7361]">
								<i class="bi bi-images text-3xl text-[#7db78d]"></i>
								<p class="mt-3 text-sm font-semibold text-[#2f5a36]">Preview foto akan muncul di sini</p>
								<p class="mt-1 text-xs">Pilih satu atau beberapa file JPG/PNG untuk melihat pratinjau langsung.</p>
							</div>
						@endif
					</div>
					<input id="galeri_files" type="file" name="galeri[]" multiple accept="image/*" class="hidden">
				</div>

				<aside class="space-y-6">
					<div class="rounded-[26px] border border-[#d7e1d6] bg-white p-5 shadow-sm">
						<p class="text-sm font-semibold text-[#173d2c]">Tips Galeri</p>
						<p class="mt-2 text-sm text-[#6f7f72]">Pilih foto yang paling representatif supaya admin lain cepat menilai rumah adat ini.</p>
					</div>
				</aside>
			</section>
		@endif

		@if ($currentStep === 4)
			<section class="grid grid-cols-1 gap-6 xl:grid-cols-[1.35fr_0.95fr]">
				<div class="rounded-[30px] border border-black/5 bg-white p-5 sm:p-6 shadow-sm">
					<div class="flex items-center gap-3">
						<div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#e0f0e0] text-[#2f5a36]"><i class="bi bi-camera-video"></i></div>
						<div>
							<h3 class="text-xl font-semibold text-[#173d2c]">Video Rumah Adat</h3>
							<p class="text-sm text-[#6f7f72]">Unggah video utama untuk pratinjau di halaman detail rumah adat.</p>
						</div>
					</div>
					<div class="mt-5 rounded-[26px] border border-[#d7e1d6] bg-[#f6f2e8] p-5 shadow-sm">
						<div class="min-h-64 rounded-[22px] bg-[linear-gradient(135deg,_#a0835c,_#2d3b2f)] flex items-center justify-center text-white overflow-hidden">
							<video id="videoPreview" class="{{ $pendingVideo ? '' : 'hidden' }} h-full w-full object-cover" controls playsinline @if ($pendingVideo) src="{{ asset('storage/' . $pendingVideo) }}" @endif></video>
							<div id="videoPlaceholder" class="{{ $pendingVideo ? 'hidden' : '' }} flex flex-col items-center gap-3 text-center">
								<label for="video_file" class="rounded-full bg-white/20 px-5 py-3 text-sm font-semibold backdrop-blur-sm cursor-pointer">Pilih Video</label>
								<p class="text-xs text-white/75">MP4, MKV, MOV. Maksimal 50MB.</p>
							</div>
						</div>
						<div class="mt-4 grid gap-4 sm:grid-cols-2">
							<label class="space-y-2 block"><span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#627467]">Judul Video</span><input type="text" name="video_judul" value="{{ old('video_judul', $currentValues['video_judul'] ?? '') }}" placeholder="Kegemahan Rumah Gadang Dt. Sinaro" class="{{ $inputClass }}"></label>
							<label class="space-y-2 block"><span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#627467]">File Video</span><input id="video_file" type="file" name="video_file" accept="video/mp4,video/x-matroska,video/quicktime" class="{{ $inputClass }} pt-2"></label>
						</div>
					</div>
				</div>

				<aside class="space-y-6">
					<div class="rounded-[26px] border border-[#1f593c] bg-[#0b442a] p-4 text-white shadow-sm">
						<p class="text-sm text-white/65">Penyimpanan Sistem</p>
						<p class="mt-2 text-3xl font-semibold">42.8 MB</p>
						<p class="mt-1 text-sm text-white/65">dipakai untuk media rumah adat</p>
						@if ($pendingVideo)
							<p class="mt-4 rounded-2xl bg-white/10 px-4 py-3 text-sm text-white/80">Draft video tersimpan: {{ basename($pendingVideo) }}</p>
						@endif
					</div>
				</aside>
			</section>
		@endif

		@if ($currentStep === 5)
			<section class="grid grid-cols-1 gap-6 xl:grid-cols-[1.35fr_0.95fr]">
				<div class="rounded-[30px] border border-black/5 bg-white p-5 sm:p-6 shadow-sm space-y-4">
					<h3 class="text-xl font-semibold text-[#173d2c]">Pratinjau &amp; Konfirmasi</h3>
					<div class="grid gap-4 md:grid-cols-2 text-sm text-[#132018]">
						<div><p class="text-xs uppercase tracking-[0.16em] text-[#627467]">Nama Rumah</p><p class="mt-1 font-semibold">{{ $currentValues['nama'] ?? '-' }}</p></div>
						<div><p class="text-xs uppercase tracking-[0.16em] text-[#627467]">Suku</p><p class="mt-1 font-semibold">{{ optional($sukuList->firstWhere('id_suku', $currentValues['suku_id'] ?? null))->nama_suku ?? '-' }}</p></div>
						<div><p class="text-xs uppercase tracking-[0.16em] text-[#627467]">Jorong</p><p class="mt-1 font-semibold">{{ optional($jorongList->firstWhere('id_jorong', $currentValues['jorong_id'] ?? null))->nama_jorong ?? '-' }}</p></div>
						<div><p class="text-xs uppercase tracking-[0.16em] text-[#627467]">Status</p><p class="mt-1 font-semibold">{{ collect($statusList)->firstWhere('value', $currentValues['status_id'] ?? null)['label'] ?? '-' }}</p></div>
					</div>
					<div class="rounded-2xl bg-[#f7faf5] p-4 text-sm text-[#6f7f72]">Pastikan semua data sudah benar sebelum disimpan.</div>
				</div>

				<aside class="space-y-6">
					<label class="flex items-start gap-3 rounded-[26px] border border-[#d7e1d6] bg-white p-5 shadow-sm">
						<input type="checkbox" name="confirm_publish" value="1" class="mt-1 h-4 w-4 rounded border-[#8eb696] text-[#2f5a36]">
						<span class="text-sm text-[#4d6150]">Saya menyatakan data yang diinput sudah akurat dan sesuai.</span>
					</label>
				</aside>
			</section>
		@endif

		<section class="flex flex-col gap-4 border-t border-black/5 pt-5 sm:flex-row sm:items-center sm:justify-between">
			<a href="{{ $currentStep === 1 ? route('admin.rumah.index') : $baseRoute . '?step=' . $prevStep }}" class="inline-flex h-12 items-center justify-center rounded-xl border border-[#d7e1d6] bg-white px-5 text-sm font-semibold text-[#173d2c] hover:bg-[#f4f8f2]">
				<i class="bi bi-arrow-left me-2"></i>{{ $currentStep === 1 ? 'Batal/Kembali' : 'Sebelumnya' }}
			</a>

			<div class="flex flex-col gap-3 sm:flex-row sm:items-center">
				<button type="submit" name="wizard_action" value="draft" class="inline-flex h-12 items-center justify-center rounded-xl border border-[#8eb696] bg-white px-6 text-sm font-semibold text-[#2f5a36] hover:bg-[#eff6ed]">
					Simpan Draft
					<i class="bi bi-bookmark ms-2"></i>
				</button>
				@if ($currentStep < 5)
					<button type="submit" class="inline-flex h-12 items-center justify-center rounded-xl bg-[#173d2c] px-6 text-sm font-semibold text-white shadow-sm shadow-[#173d2c]/20 hover:bg-[#21503a]">
						{{ $nextStepLabel ? 'Lanjut ke ' . $nextStepLabel : 'Lanjut' }}
						<i class="bi bi-arrow-right ms-2"></i>
					</button>
				@else
					<button type="submit" class="inline-flex h-12 items-center justify-center rounded-xl bg-[#173d2c] px-6 text-sm font-semibold text-white shadow-sm shadow-[#173d2c]/20 hover:bg-[#21503a]">
						{{ $mode === 'edit' ? 'Simpan Perubahan' : 'Simpan &amp; Selesai' }}
						<i class="bi bi-check2-circle ms-2"></i>
					</button>
				@endif
			</div>
		</section>
	</form>
</div>

@push('scripts')
<script>
(function () {
	const galleryInput = document.getElementById('galeri_files');
	const galleryGrid = document.getElementById('galleryPreviewGrid');
	const videoInput = document.getElementById('video_file');
	const videoPreview = document.getElementById('videoPreview');
	const videoPlaceholder = document.getElementById('videoPlaceholder');
	let galleryUrls = [];
	let videoUrl = null;

	if (galleryInput && galleryGrid) {
		galleryInput.addEventListener('change', function () {
			galleryUrls.forEach((url) => URL.revokeObjectURL(url));
			galleryUrls = [];

			const files = Array.from(galleryInput.files || []);
			galleryGrid.innerHTML = '';

			if (!files.length) {
				galleryGrid.innerHTML = '<div class="col-span-full rounded-2xl border border-dashed border-[#b9d2be] bg-[#f8fbf7] p-8 text-center text-[#5d7361]"><i class="bi bi-images text-3xl text-[#7db78d]"></i><p class="mt-3 text-sm font-semibold text-[#2f5a36]">Preview foto akan muncul di sini</p><p class="mt-1 text-xs">Pilih satu atau beberapa file JPG/PNG untuk melihat pratinjau langsung.</p></div>';
				return;
			}

			files.forEach((file) => {
				const url = URL.createObjectURL(file);
				galleryUrls.push(url);
				const card = document.createElement('div');
				card.className = 'overflow-hidden rounded-2xl border border-[#d7e1d6] bg-[#fbfcfa] shadow-sm';
				card.innerHTML = `
					<div class="h-32 bg-[#eef2ec]">
						<img src="${url}" alt="${file.name}" class="h-full w-full object-cover">
					</div>
					<div class="p-3">
						<p class="text-sm font-semibold text-[#132018] truncate">${file.name}</p>
						<p class="mt-1 text-xs text-[#6f7f72]">${Math.max(1, Math.round(file.size / 1024))} KB</p>
					</div>
				`;
				galleryGrid.appendChild(card);
			});
		});
	}

	if (videoInput && videoPreview && videoPlaceholder) {
		videoInput.addEventListener('change', function () {
			if (videoUrl) {
				URL.revokeObjectURL(videoUrl);
				videoUrl = null;
			}

			const file = videoInput.files && videoInput.files[0];
			if (!file) {
				videoPreview.pause();
				videoPreview.classList.add('hidden');
				videoPreview.removeAttribute('src');
				videoPlaceholder.classList.remove('hidden');
				return;
			}

			videoUrl = URL.createObjectURL(file);
			videoPreview.src = videoUrl;
			videoPreview.classList.remove('hidden');
			videoPlaceholder.classList.add('hidden');
			videoPreview.load();
		});
	}
})();
</script>
@endpush