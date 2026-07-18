@php
	$navigation = [
		['label' => 'Dashboard', 'icon' => 'bi-grid-1x2', 'route' => 'admin.dashboard'],
		['label' => 'Rumah Adat', 'icon' => 'bi-house-door', 'route' => 'admin.rumah.index'],
		['label' => 'Fasilitas', 'icon' => 'bi-buildings', 'route' => 'admin.fasilitas.index'],
		['label' => 'Detail Rumah Gadang', 'icon' => 'bi-journal-text', 'route' => 'admin.tentang.index'],
	];

	$isActive = function (string $route) {
		return request()->routeIs($route) || request()->routeIs($route . '.*');
	};
@endphp

<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 flex flex-col w-72 bg-[#0b442a] text-white min-h-screen shadow-2xl shadow-emerald-950/20 -translate-x-full transition-transform duration-300 lg:static lg:z-auto lg:translate-x-0 lg:shadow-2xl lg:shadow-emerald-950/20">
	<div class="px-6 pt-6 pb-5 border-b border-white/10">
		<div class="flex items-center justify-between lg:hidden mb-3">
			<button type="button" class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-white/15 bg-white/10 text-white" onclick="window.toggleAdminSidebar()" aria-label="Buka atau tutup menu admin">
				<i class="bi bi-list text-lg"></i>
			</button>
			<button type="button" class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-white/15 bg-white/10 text-white" onclick="window.closeAdminSidebar()" aria-label="Tutup menu admin">
				<i class="bi bi-x-lg"></i>
			</button>
		</div>
		<a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center text-center gap-3">
			<div class="w-16 h-16 rounded-full bg-white/95 text-[#0b442a] flex items-center justify-center overflow-hidden shadow-lg">
				<img src="{{ asset('assets/logo.png') }}" alt="Logo Kampung Adat" class="w-12 h-12 object-contain">
			</div>
			<div>
				<p class="text-xl leading-tight font-semibold">Kampung Adat</p>
				<p class="text-sm text-white/80">Muaro Sijunjung</p>
			</div>
		</a>
	</div>

	<nav class="px-4 py-5 space-y-1 flex-1">
		@foreach ($navigation as $item)
			<a
				href="{{ route($item['route']) }}"
				class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ $isActive($item['route']) ? 'bg-[#155c37] text-white shadow-lg shadow-black/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}"
			>
				<i class="bi {{ $item['icon'] }} text-base"></i>
				<span class="text-sm font-medium">{{ $item['label'] }}</span>
			</a>
		@endforeach
	</nav>

	<div class="px-4 pb-5 pt-4 border-t border-white/10">
		<a href="{{ route('admin.profile') }}" class="rounded-2xl bg-white/8 border border-white/10 px-4 py-4 backdrop-blur-sm block hover:bg-white/12 transition-colors">
			<div class="flex items-center gap-3">
				<div class="w-10 h-10 rounded-full bg-[#c7dfc1] text-[#0b442a] flex items-center justify-center font-semibold">A</div>
				<div class="min-w-0">
					<p class="text-sm font-semibold leading-tight">Admin</p>
					<p class="text-xs text-white/70 truncate">Nama Admin</p>
				</div>
			</div>
		</a>
	</div>
</aside>
