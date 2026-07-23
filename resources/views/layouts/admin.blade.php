<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Admin Kampung Adat')</title>
	<meta name="description" content="@yield('meta_description', 'Panel administrasi WebGIS Kampung Adat Sijunjung')">

	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

	@vite(['resources/css/app.css', 'resources/js/app.js'])
	@stack('styles')
</head>

<body class="font-sans antialiased bg-[#f4f6f2] text-[#132018]">
	<div id="admin-sidebar-overlay" class="fixed inset-0 z-30 bg-black/35 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden" onclick="window.closeAdminSidebar()"></div>

	<div class="min-h-screen bg-[#f4f6f2] lg:flex">
		@include('partials.sidebar-admin')

		<div class="flex-1 min-w-0">
			<header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-black/5">
				<div class="h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
					<div class="flex items-center gap-3">
						<button type="button" class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl border border-[#d9e3d8] bg-white text-[#4d6150]" onclick="window.toggleAdminSidebar()" aria-label="Buka menu admin">
							<i class="bi bi-list text-lg"></i>
						</button>
						<div>
						<p class="text-sm text-[#56715d]">@yield('eyebrow', 'Dashboard')</p>
						<h1 class="text-xl md:text-2xl font-semibold text-[#132018]">@yield('page_title', 'Admin Kampung Adat')</h1>
						</div>
					</div>

					<div class="flex items-center gap-3">
						<form method="GET" action="{{ route('admin.dashboard') }}" class="hidden md:block">
							<label class="flex items-center gap-2 w-72 h-10 px-4 rounded-full bg-[#edf3ea] text-[#6d7f72] border border-transparent focus-within:border-[#b8c7b7]">
								<i class="bi bi-search"></i>
								<input
									type="search"
									name="search"
									value="{{ request('search') }}"
									placeholder="Cari data heritage..."
									class="w-full bg-transparent outline-none text-sm placeholder:text-[#8b9a8f]"
								>
							</label>
						</form>
						<a href="{{ route('admin.profile') }}" class="w-10 h-10 rounded-full overflow-hidden border border-[#d9e3d8] bg-[#d8e8d2] flex items-center justify-center text-[#2f5a36] font-semibold hover:ring-2 hover:ring-[#c5d9c0] transition" aria-label="Buka profil admin">
							AD
						</a>
					</div>
				</div>
			</header>

			<main class="px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
				@yield('content')
			</main>
		</div>
	</div>

	@stack('scripts')
</body>
</html>
