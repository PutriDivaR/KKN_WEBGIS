@extends('layouts.admin')

@section('title', 'Profil Admin — Kampung Adat')
@section('eyebrow', 'Profil Admin')
@section('page_title', 'Profil Admin')

@section('content')
	<div class="max-w-4xl space-y-6">
		<section class="rounded-3xl border border-black/5 bg-white p-6 shadow-sm">
			<div class="flex flex-col md:flex-row md:items-center gap-5">
				<div class="w-20 h-20 rounded-full bg-[#d8e8d2] text-[#0b442a] flex items-center justify-center text-2xl font-semibold shrink-0">AD</div>
				<div class="flex-1">
					<p class="text-sm text-[#6f7f72]">Akun admin sementara</p>
					<h2 class="text-2xl font-semibold text-[#132018] mt-1">{{ $name }}</h2>
					<p class="text-sm text-[#6f7f72] mt-1">{{ $email }}</p>
				</div>
				<div class="flex gap-3">
					<a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center h-11 px-5 rounded-xl border border-[#d7e1d6] text-sm font-semibold text-[#0b442a] hover:bg-[#f4f8f2]">
						Kembali ke Dashboard
					</a>
					<form method="POST" action="{{ route('admin.logout') }}">
						@csrf
						<button type="submit" class="inline-flex items-center justify-center h-11 px-5 rounded-xl bg-[#173d2c] text-white text-sm font-semibold hover:bg-[#21503a]">
							Keluar
						</button>
					</form>
				</div>
			</div>
		</section>

		<section class="grid grid-cols-1 md:grid-cols-2 gap-4">
			<div class="rounded-3xl border border-black/5 bg-white p-6 shadow-sm">
				<p class="text-sm text-[#6f7f72]">Status Login</p>
				<p class="mt-2 text-lg font-semibold text-[#132018]">Aktif di session dummy</p>
			</div>
			<div class="rounded-3xl border border-black/5 bg-white p-6 shadow-sm">
				<p class="text-sm text-[#6f7f72]">Hak akses</p>
				<p class="mt-2 text-lg font-semibold text-[#132018]">Dashboard, Rumah Adat, Fasilitas</p>
			</div>
		</section>
	</div>
@endsection