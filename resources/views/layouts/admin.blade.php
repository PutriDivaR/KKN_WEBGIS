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
	<div class="min-h-screen flex bg-[#f4f6f2]">
		@include('partials.sidebar-admin')

		<div class="flex-1 min-w-0 lg:ml-0">
			<header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-black/5">
				<div class="h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
					<div>
						<p class="text-sm text-[#56715d]">@yield('eyebrow', 'Dashboard')</p>
						<h1 class="text-xl md:text-2xl font-semibold text-[#132018]">@yield('page_title', 'Admin Kampung Adat')</h1>
					</div>

					<div class="flex items-center gap-3">
						<label class="hidden md:flex items-center gap-2 w-72 h-10 px-4 rounded-full bg-[#edf3ea] text-[#6d7f72] border border-transparent focus-within:border-[#b8c7b7]">
							<i class="bi bi-search"></i>
							<input type="search" placeholder="Cari data heritage..." class="w-full bg-transparent outline-none text-sm placeholder:text-[#8b9a8f]">
						</label>
						<button type="button" class="w-10 h-10 rounded-full border border-[#d9e3d8] bg-white text-[#4d6150] flex items-center justify-center">
							<i class="bi bi-bell"></i>
						</button>
						<div class="w-10 h-10 rounded-full overflow-hidden border border-[#d9e3d8] bg-[#d8e8d2] flex items-center justify-center text-[#2f5a36] font-semibold">
							AD
						</div>
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
