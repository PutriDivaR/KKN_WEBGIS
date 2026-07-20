@extends('layouts.admin')

@section('title', 'Detail Rumah Adat — Admin Kampung Adat')
@section('eyebrow', 'Rumah Adat')
@section('page_title', 'Detail Rumah Adat')

@section('content')
	@php
		$gallery = $rumah->media->where('jenis_media', 'foto');
		$video = $rumah->media->firstWhere('jenis_media', 'video');
	@endphp

	<div class="space-y-6">
		<section class="rounded-3xl border border-black/5 bg-white p-5 sm:p-6 shadow-sm">
			<div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
				<div class="max-w-3xl">
					<p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#6f7f72]">Nomor Rumah {{ $rumah->nomor_rumah ?? '-' }}</p>
					<h1 class="mt-2 text-3xl font-semibold text-[#132018]">{{ $rumah->nama_tampil }}</h1>
					<p class="mt-3 text-sm leading-6 text-[#6f7f72]">{{ $rumah->alamat_label }}</p>
					<div class="mt-4 flex flex-wrap gap-2 text-sm">
						<span class="rounded-full bg-[#e5f1e2] px-3 py-1 font-semibold text-[#0b6a38]">{{ $rumah->status_label }}</span>
						<span class="rounded-full bg-[#eef4ea] px-3 py-1 font-semibold text-[#4f6652]">{{ $rumah->kategori_label }}</span>
						<span class="rounded-full bg-[#f4efe6] px-3 py-1 font-semibold text-[#8b6a2f]">{{ $rumah->suku_label }}</span>
					</div>
				</div>

				<div class="flex flex-wrap gap-3">
					<a href="{{ route('admin.rumah.edit', $rumah->id_rumah) }}" class="inline-flex items-center justify-center h-11 px-5 rounded-xl bg-[#173d2c] text-white text-sm font-semibold hover:bg-[#21503a]">
						<i class="bi bi-pencil me-2"></i>Ubah Data
					</a>
					<a href="{{ route('admin.rumah.index') }}" class="inline-flex items-center justify-center h-11 px-5 rounded-xl border border-[#d7e1d6] text-sm font-semibold text-[#0b442a] hover:bg-[#f4f8f2]">
						Kembali
					</a>
				</div>
			</div>
		</section>

		<section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
			<div class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
				<p class="text-xs uppercase tracking-[0.18em] text-[#6f7f72]">Pemilik</p>
				<p class="mt-2 text-lg font-semibold text-[#132018]">{{ $rumah->pemilik_label }}</p>
			</div>
			<div class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
				<p class="text-xs uppercase tracking-[0.18em] text-[#6f7f72]">Jorong</p>
				<p class="mt-2 text-lg font-semibold text-[#132018]">{{ $rumah->jorong_label }}</p>
			</div>
			<div class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
				<p class="text-xs uppercase tracking-[0.18em] text-[#6f7f72]">Jumlah Penghuni</p>
				<p class="mt-2 text-lg font-semibold text-[#132018]">{{ $rumah->jumlah_penghuni_label }}</p>
			</div>
			<div class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
				<p class="text-xs uppercase tracking-[0.18em] text-[#6f7f72]">Koordinat</p>
				<p class="mt-2 text-lg font-semibold text-[#132018]">{{ $rumah->koordinat_label }}</p>
			</div>
		</section>

		<section class="grid grid-cols-1 gap-6 xl:grid-cols-[1.2fr_0.8fr]">
			<article class="rounded-3xl border border-black/5 bg-white p-5 sm:p-6 shadow-sm space-y-5">
				<div class="flex items-center justify-between gap-4">
					<div>
						<h2 class="text-xl font-semibold text-[#132018]">Sejarah Rumah</h2>
						<p class="mt-1 text-sm text-[#6f7f72]">Ringkasan narasi yang tersimpan pada data rumah adat.</p>
					</div>
				</div>
				<div class="rounded-2xl bg-[#f7faf5] p-4 text-sm leading-7 text-[#34463a] whitespace-pre-line">
					{{ $rumah->sejarah_teks }}
				</div>
			</article>

			<aside class="space-y-6">
				<div class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
					<p class="text-sm font-semibold text-[#132018]">Informasi Tambahan</p>
					<div class="mt-4 space-y-3 text-sm text-[#6f7f72]">
						<p><span class="font-semibold text-[#132018]">Tahun dibangun:</span> {{ $rumah->tahun_dibangun_label }}</p>
						<p><span class="font-semibold text-[#132018]">Ninik mamak:</span> {{ $rumah->ninik_mamak_label }}</p>
						<p><span class="font-semibold text-[#132018]">Status hunian:</span> {{ $rumah->status_label }}</p>
						<p><span class="font-semibold text-[#132018]">Jumlah KK:</span> {{ $rumah->jumlah_kk_label }}</p>
					</div>
				</div>

				<div class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
					<p class="text-sm font-semibold text-[#132018]">Media Utama</p>
					@if ($video)
						<div class="mt-4 overflow-hidden rounded-2xl border border-[#d7e1d6] bg-[#f7faf5]">
							<video controls class="h-56 w-full object-cover" src="{{ asset('storage/' . $video->file) }}"></video>
						</div>
						<p class="mt-3 text-sm text-[#6f7f72]">{{ $video->nama_file }}</p>
					@else
						<div class="mt-4 rounded-2xl border border-dashed border-[#d7e1d6] bg-[#fafcf8] p-6 text-center text-sm text-[#6f7f72]">
							Video belum tersedia.
						</div>
					@endif
				</div>
			</aside>
		</section>

		<section class="rounded-3xl border border-black/5 bg-white p-5 sm:p-6 shadow-sm">
			<div class="flex items-center justify-between gap-4">
				<div>
					<h2 class="text-xl font-semibold text-[#132018]">Galeri Foto</h2>
					<p class="mt-1 text-sm text-[#6f7f72]">Dokumentasi visual yang melekat pada rumah adat ini.</p>
				</div>
				<p class="text-sm text-[#6f7f72]">{{ $gallery->count() }} foto</p>
			</div>

			<div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
				@forelse ($gallery as $photo)
					<figure class="overflow-hidden rounded-2xl border border-[#d7e1d6] bg-[#fbfcfa] shadow-sm">
						<div class="h-44 bg-[#eef2ec]">
							<img src="{{ asset('storage/' . $photo->file) }}" alt="{{ $photo->nama_file }}" class="h-full w-full object-cover">
						</div>
						<figcaption class="p-4">
							<p class="text-sm font-semibold text-[#132018] truncate">{{ $photo->nama_file }}</p>
						</figcaption>
					</figure>
				@empty
					<div class="col-span-full rounded-2xl border border-dashed border-[#d7e1d6] bg-[#fafcf8] p-8 text-center text-sm text-[#6f7f72]">
						Belum ada foto yang tersimpan.
					</div>
				@endforelse
			</div>
		</section>
	</div>
@endsection