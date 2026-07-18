@extends('layouts.admin')

@section('title', 'Detail Rumah Gadang — Admin Kampung Adat')
@section('eyebrow', 'Detail Rumah Gadang')
@section('page_title', 'Tentang Kampung Adat Sijunjung')

@section('content')
	<div class="grid grid-cols-1 xl:grid-cols-[260px_minmax(0,1fr)] gap-6 items-start">
		<aside class="rounded-2xl border border-black/5 bg-white p-3 shadow-sm xl:sticky xl:top-24">
			<nav class="space-y-1">
				@foreach ($sections as $section)
					<a href="#{{ strtolower(str_replace(' ', '-', $section['label'])) }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium {{ $loop->first ? 'bg-[#1d6b44] text-white' : 'text-[#566a5a] hover:bg-[#f1f6ef]' }}">
						<i class="bi {{ $section['icon'] }} text-base"></i>
						<span>{{ $section['label'] }}</span>
					</a>
				@endforeach
			</nav>
		</aside>

		<section class="space-y-6">
			<article id="profil-kampung" class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
				<div class="flex items-center justify-between gap-4 mb-4">
					<div>
						<h2 class="text-lg font-semibold text-[#132018]">Foto Sampul</h2>
						<p class="text-sm text-[#6f7f72]">Tampilan umum kampung adat</p>
					</div>
					<button type="button" class="inline-flex items-center gap-2 h-10 px-4 rounded-xl border border-[#d7e1d6] text-sm font-semibold text-[#0b442a] hover:bg-[#f4f8f2]">
						<i class="bi bi-camera"></i>
						Ubah Foto
					</button>
				</div>

				<div class="rounded-2xl overflow-hidden border border-black/5 bg-[#edf2ec]">
					<img src="{{ asset('assets/wallpaper_beranda.jpeg') }}" alt="Foto sampul Kampung Adat Sijunjung" class="w-full h-64 md:h-80 object-cover object-center">
				</div>
			</article>

			<article id="sejarah" class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
				<h2 class="text-lg font-semibold text-[#132018]">Deskripsi Profil</h2>
				<p class="mt-1 text-sm text-[#6f7f72]">Sampaikan narasi terbaik tentang keasrian dan kearifan lokal Kampung Adat Sijunjung.</p>

				<div class="mt-4 rounded-2xl border border-[#d7e1d6] overflow-hidden">
					<div class="flex flex-wrap items-center gap-2 px-4 py-3 bg-[#f5f7fb] border-b border-[#d7e1d6] text-[#4d6150] text-sm">
						<button type="button" class="font-semibold">B</button>
						<button type="button" class="italic">I</button>
						<button type="button" class="underline">U</button>
						<span class="w-px h-5 bg-[#d7e1d6] mx-2"></span>
						<button type="button">•</button>
						<button type="button">1.</button>
						<button type="button">❝</button>
						<button type="button">🔗</button>
						<button type="button">🖼</button>
						<div class="ml-auto flex items-center gap-2 text-[#7b8d80]">
							<button type="button">↶</button>
							<button type="button">↷</button>
						</div>
					</div>

					<div class="p-5 space-y-4 text-sm leading-7 text-[#34463a]">
						<p>Kampung Adat Sijunjung merupakan salah satu kawasan permukiman adat Minangkabau yang masih terjaga hingga saat ini. Kampung ini terdiri dari beberapa jorong yang dihuni oleh masyarakat berdasarkan sistem kekerabatan matrilineal. Keunikan utama kawasan ini adalah keberadaan puluhan Rumah Gadang yang berjajar rapi mengikuti topografi lahan.</p>
						<p>Kampung Adat Sijunjung telah berdiri sejak abad ke-18 dan menjadi pusat kehidupan sosial, budaya, dan spiritual masyarakat setempat. Pada tahun 2018, kawasan ini resmi diusulkan sebagai salah satu warisan dunia UNESCO karena integritas budaya dan arsitekturnya yang luar biasa.</p>
						<p>Visi pengembangannya fokus pada konservasi berbasis masyarakat, di mana kearifan lokal tetap menjadi pondasi utama dalam menyambut modernitas dan pariwisata berkelanjutan.</p>
					</div>
			</article>

			<div class="grid grid-cols-1 xl:grid-cols-[1fr_auto] gap-4 items-end">
				<article id="tim-pengembang" class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
					<p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#7b8d80]">Catatan Perubahan (Opsional)</p>
					<div class="mt-3 rounded-2xl border border-[#d7e1d6] bg-[#f9faf8] p-4 text-sm text-[#7b8d80]">
						Contoh: Pembaruan data sejarah berdasarkan hasil riset terbaru 2024..
					</div>
				</article>

				<div class="flex flex-col sm:flex-row xl:flex-col gap-3">
					<button type="button" class="inline-flex items-center justify-center h-11 px-5 rounded-xl bg-[#1d6b44] text-white text-sm font-semibold hover:bg-[#235f3f]">
						Simpan Perubahan
					</button>
					<button type="button" class="inline-flex items-center justify-center h-11 px-5 rounded-xl border border-[#d7e1d6] text-sm font-semibold text-[#6f7f72] hover:bg-[#f4f8f2]">
						Batalkan Perubahan
					</button>
				</div>
			</div>
		</section>
	</div>
@endsection
