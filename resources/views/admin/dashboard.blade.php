@extends('layouts.admin')

@section('title', 'Dashboard Admin — Kampung Adat')
@section('eyebrow', 'Dashboard')
@section('page_title', 'Dashboard Kampung Adat')

@section('content')
	<div class="space-y-6">
		@if (!empty($search))
			<div class="rounded-2xl border border-[#d7e1d6] bg-white px-4 py-3 text-sm text-[#4d6150] shadow-sm">
				Hasil pencarian untuk: <span class="font-semibold text-[#132018]">{{ $search }}</span>
			</div>
		@endif

		@if ($latestCards === [] && $activities === [])
			<div class="rounded-2xl border border-dashed border-[#d7e1d6] bg-white px-4 py-8 text-center text-[#6f7f72] shadow-sm">
				Tidak ada data yang cocok dengan pencarian ini.
			</div>
		@endif

		<section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
			@foreach ($stats as $stat)
				<article class="rounded-2xl border border-black/5 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
					<div class="flex items-start justify-between gap-4">
						<div class="w-11 h-11 rounded-xl bg-[#e7f2e7] text-[#0b442a] flex items-center justify-center text-lg shrink-0">
							<i class="bi {{ $stat['icon'] }}"></i>
						</div>
						<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $loop->index === 0 ? 'bg-[#def2e1] text-[#0b6a38]' : ($loop->index === 1 ? 'bg-[#e8f3e4] text-[#4f7e58]' : ($loop->index === 2 ? 'bg-[#fdebdc] text-[#b35a1a]' : 'bg-[#eef3ea] text-[#5d6c60]')) }}">
							{{ $stat['badge'] }}
						</span>
					</div>
					<p class="mt-4 text-[11px] uppercase tracking-[0.22em] text-[#6f7f72]">{{ $stat['label'] }}</p>
					<p class="mt-1 text-[2.1rem] font-semibold leading-none text-[#132018]">{{ $stat['value'] }}</p>
				</article>
			@endforeach
		</section>

		<section class="grid grid-cols-1 xl:grid-cols-[minmax(0,1.7fr)_minmax(280px,1fr)] gap-5 items-start">
			<article class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
				<div class="flex items-start justify-between gap-4 mb-4">
					<div>
						<h2 class="text-lg font-semibold text-[#132018]">Ringkasan Peta</h2>
						<p class="text-sm text-[#6f7f72]">Sebaran status rumah adat & fasilitas</p>
					</div>
					<a href="{{ route('admin.rumah.index') }}" class="text-sm font-medium text-[#0b6a38] hover:underline inline-flex items-center gap-1">
						Lihat Detail
						<i class="bi bi-box-arrow-up-right text-xs"></i>
					</a>
				</div>

				<div class="rounded-2xl overflow-hidden border border-black/5 bg-[#edf2ec] h-[28rem] relative">
					<img
						src="{{ asset('assets/siteplan(dummy).png') }}"
						alt="Ringkasan peta kampung adat"
						class="absolute inset-0 w-full h-full object-cover"
					>
					<div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-white/5 pointer-events-none"></div>

					<div class="absolute left-4 top-4 right-4 flex items-center justify-between gap-3">
						<span class="inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-[#4f6652] shadow-sm">Dashboard | Light Mode</span>
						<div class="inline-flex items-center gap-1 rounded-full bg-white/90 px-2 py-1 shadow-sm">
							<button type="button" class="w-7 h-7 rounded-full border border-[#d9e3d8] text-[#4d6150] flex items-center justify-center">+</button>
							<button type="button" class="w-7 h-7 rounded-full border border-[#d9e3d8] text-[#4d6150] flex items-center justify-center">−</button>
						</div>
					</div>

					<div class="absolute left-4 bottom-4 flex flex-col gap-2 rounded-2xl bg-white/95 backdrop-blur px-4 py-3 shadow-lg max-w-[14rem]">
						@foreach ($mapSummary as $summary)
							<div class="flex items-center gap-2 text-sm">
								<span class="w-3 h-3 rounded-full {{ $summary['color'] }}"></span>
								<span class="text-[#34463a]">{{ $summary['label'] }} ({{ $summary['count'] }})</span>
							</div>
						@endforeach
					</div>
				</div>
			</article>

			<article class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm h-full">
				<div class="mb-4">
					<h2 class="text-lg font-semibold text-[#132018]">Aktivitas Terbaru</h2>
					<p class="text-sm text-[#6f7f72]">Update terakhir dari admin</p>
				</div>

				<div class="space-y-0">
					@forelse ($activities as $activity)
						<div class="flex gap-3 pb-4 {{ $loop->last ? '' : 'border-b border-black/5 mb-4' }}">
							<div class="mt-0.5 w-9 h-9 rounded-full bg-[#e8f3e4] text-[#0b6a38] flex items-center justify-center shrink-0">
								<i class="bi {{ $activity['icon'] }}"></i>
							</div>
							<div>
								<p class="text-sm font-semibold text-[#132018] leading-snug">{{ $activity['title'] }}</p>
								<p class="mt-1 text-xs text-[#6f7f72]">{{ $activity['time'] }}</p>
							</div>
						</div>
					@empty
						<p class="text-sm text-[#6f7f72]">Tidak ada aktivitas yang cocok.</p>
					@endforelse
				</div>

				<a href="{{ route('admin.aktivitas.index') }}" class="mt-2 inline-flex items-center justify-center w-full rounded-xl border border-[#d8e5d6] px-4 py-3 text-sm font-medium text-[#0b442a] hover:bg-[#f2f7f0]">
					Lihat Semua Aktivitas
				</a>
			</article>
		</section>

		<section>
			<div class="flex items-center justify-between mb-4 gap-4">
				<div>
					<h2 class="text-xl font-semibold text-[#132018]">Data Terbaru</h2>
					<p class="text-sm text-[#6f7f72]">Rumah adat dan fasilitas yang baru saja didaftarkan</p>
				</div>
				<div class="flex items-center gap-2">
					<button class="w-9 h-9 rounded-full border border-[#d8e5d6] bg-white text-[#0b442a]" type="button"><i class="bi bi-chevron-left"></i></button>
					<button class="w-9 h-9 rounded-full border border-[#d8e5d6] bg-white text-[#0b442a]" type="button"><i class="bi bi-chevron-right"></i></button>
				</div>
			</div>

				<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
					@forelse ($latestCards as $card)
					<a href="{{ $card['route'] }}" class="group block overflow-hidden rounded-2xl border border-black/5 bg-white shadow-sm hover:shadow-md transition-shadow focus:outline-none focus:ring-2 focus:ring-[#0b442a]/30">
						<div class="relative h-40 overflow-hidden bg-[#edf2ec]">
							<img
								src="{{ $card['image'] }}"
								alt="{{ $card['name'] }}"
								class="w-full h-full object-cover"
								style="object-position: {{ $card['image_position'] }};"
							>
							<div class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent"></div>
							<span class="absolute right-3 top-3 rounded-full bg-[#0b442a] px-3 py-1 text-[11px] font-semibold text-white shadow-sm">{{ $card['status'] }}</span>
						</div>
						<div class="p-4">
							<h3 class="font-semibold text-[#132018] text-[15px]">{{ $card['name'] }}</h3>
							<p class="mt-1 text-sm text-[#6f7f72]">{{ $card['meta'] }}</p>
							<div class="mt-4 flex items-center justify-start text-sm">
								<span class="inline-flex items-center rounded-full bg-[#e8f3e4] px-2.5 py-1 text-[11px] font-medium text-[#0b6a38]">{{ ucfirst($card['type']) }}</span>
							</div>
						</div>
					</a>
					@empty
						<div class="col-span-full rounded-2xl border border-dashed border-[#d7e1d6] bg-white p-8 text-center text-[#6f7f72]">
							Tidak ada data terbaru yang cocok.
						</div>
					@endforelse
			</div>
		</section>
	</div>
@endsection
