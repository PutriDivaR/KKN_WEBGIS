@extends('layouts.admin')

@section('title', 'Aktivitas Terbaru — Admin Kampung Adat')
@section('eyebrow', 'Aktivitas Terbaru')
@section('page_title', 'Aktivitas Admin')

@section('content')
	<div class="space-y-6">
		<section class="grid grid-cols-1 md:grid-cols-3 gap-4">
			@foreach ($summary as $item)
				<article class="rounded-2xl border border-black/5 bg-white p-5 shadow-sm">
					<div class="w-11 h-11 rounded-xl bg-[#e7f2e7] text-[#0b442a] flex items-center justify-center text-lg shrink-0">
						<i class="bi {{ $item['icon'] }}"></i>
					</div>
					<p class="mt-4 text-xs uppercase tracking-[0.22em] text-[#6f7f72]">{{ $item['label'] }}</p>
					<p class="mt-1 text-3xl font-semibold text-[#132018]">{{ $item['value'] }}</p>
				</article>
			@endforeach
		</section>

		<section class="rounded-3xl border border-black/5 bg-white p-5 shadow-sm">
			<div class="flex items-start justify-between gap-4 mb-4">
				<div>
					<h2 class="text-lg font-semibold text-[#132018]">Daftar Aktivitas</h2>
					<p class="text-sm text-[#6f7f72]">Seluruh aktivitas terbaru rumah adat dan fasilitas</p>
				</div>
				<a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-[#0b6a38] hover:underline">Kembali ke Dashboard</a>
			</div>

			<div class="space-y-3">
				@foreach ($activities as $activity)
					<a href="{{ $activity['route'] }}" class="group flex items-center gap-4 rounded-2xl border border-[#e9eee8] p-4 hover:bg-[#f8fbf7] transition-colors">
						<div class="w-11 h-11 rounded-full bg-[#e8f3e4] text-[#0b6a38] flex items-center justify-center shrink-0">
							<i class="bi {{ $activity['icon'] }}"></i>
						</div>
						<div class="flex-1 min-w-0">
							<div class="flex items-center justify-between gap-3">
								<h3 class="text-sm font-semibold text-[#132018] truncate">{{ $activity['title'] }}</h3>
								<span class="inline-flex items-center rounded-full bg-[#eef3ea] px-2.5 py-1 text-[11px] font-medium text-[#5d6c60] shrink-0">{{ $activity['category'] }}</span>
							</div>
							<p class="mt-1 text-xs text-[#6f7f72]">{{ $activity['time'] }}</p>
						</div>
						<i class="bi bi-chevron-right text-[#a2b0a4] group-hover:text-[#0b442a]"></i>
					</a>
				@endforeach
			</div>
		</section>
	</div>
@endsection