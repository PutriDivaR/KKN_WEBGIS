@extends('layouts.admin')

@section('title', 'Daftar Rumah Adat')
@section('eyebrow', 'Rumah Adat')
@section('page_title', 'Daftar Rumah Adat')

@section('content')
	<div class="space-y-6">
		<section class="rounded-3xl border border-black/5 bg-white p-4 sm:p-6 shadow-sm">
			<form method="GET" action="{{ route('admin.rumah.index') }}" class="grid grid-cols-1 xl:grid-cols-[1fr_auto_auto_auto] gap-3">
				<label class="flex items-center gap-2 h-11 px-4 rounded-xl border border-[#d7e1d6] bg-white text-[#6d7f72]">
					<i class="bi bi-search"></i>
					<input
						type="search"
						name="search"
						value="{{ $filters['search'] }}"
						placeholder="Cari nama rumah..."
						class="w-full bg-transparent outline-none text-sm text-[#132018] placeholder:text-[#8b9a8f]"
					>
				</label>

				<select name="suku" class="h-11 rounded-xl border border-[#d7e1d6] bg-white px-4 text-sm text-[#132018] outline-none">
					<option value="">Semua Suku</option>
					@foreach ($sukuList as $suku)
						<option value="{{ $suku->id_suku }}" @selected((string) $filters['suku'] === (string) $suku->id_suku)>{{ $suku->nama_suku }}</option>
					@endforeach
				</select>

				<select name="status" class="h-11 rounded-xl border border-[#d7e1d6] bg-white px-4 text-sm text-[#132018] outline-none">
					<option value="">Semua Status</option>
					@foreach ($statusList as $status)
						<option value="{{ $status['value'] }}" @selected((string) $filters['status'] === (string) $status['value'])>{{ $status['label'] }}</option>
					@endforeach
				</select>

				<div class="flex items-stretch gap-3">
					<button type="submit" class="h-11 px-5 rounded-xl bg-[#0b442a] text-white text-sm font-semibold hover:bg-[#0f5331]">
						<i class="bi bi-filter me-2"></i>Terapkan
					</button>
					<a href="{{ route('admin.rumah.index') }}" class="h-11 px-5 rounded-xl border border-[#d7e1d6] text-sm font-semibold text-[#0b442a] flex items-center justify-center hover:bg-[#f4f8f2]">
						Reset
					</a>
					<a href="{{ route('admin.rumah.create') }}" class="h-11 px-5 rounded-xl bg-[#173d2c] text-white text-sm font-semibold flex items-center justify-center hover:bg-[#21503a]">
						<i class="bi bi-plus-lg me-2"></i>Tambah Rumah Adat
					</a>
				</div>
			</form>
		</section>

		<section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-5">
			@forelse ($rumah as $item)
				<article class="overflow-hidden rounded-3xl border border-black/5 bg-white shadow-sm">
					<div class="relative h-56 bg-gradient-to-br from-[#8ea48a] via-[#c8d5be] to-[#efeadf]">
						<span class="absolute left-3 top-3 rounded-full px-3 py-1 text-[11px] font-semibold {{ $item['status'] === 'dihuni' ? 'bg-[#dff2e5] text-[#0b6a38]' : 'bg-[#fdebdc] text-[#b35a1a]' }}">
							{{ $item['status'] === 'dihuni' ? 'Masih Dihuni' : 'Kosong' }}
						</span>
						<div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black/45 to-transparent">
							<p class="text-sm text-white/90">{{ $item['lokasi'] }}</p>
						</div>
					</div>

					<div class="p-5">
						<div class="flex items-start justify-between gap-4">
							<div>
								<h2 class="text-lg font-semibold text-[#132018]">{{ $item['nama'] }}</h2>
								<p class="mt-1 text-sm text-[#6f7f72]">{{ $item['suku'] }}</p>
							</div>
							<div class="flex items-center gap-2 text-[#6f7f72]">
									<a href="{{ route('admin.rumah.show', $item['id']) }}" class="w-8 h-8 rounded-full hover:bg-[#f4f7f2] inline-flex items-center justify-center"><i class="bi bi-eye"></i></a>
									<a href="{{ route('admin.rumah.edit', $item['id']) }}" class="w-8 h-8 rounded-full hover:bg-[#f4f7f2] inline-flex items-center justify-center"><i class="bi bi-pencil"></i></a>
									<form method="POST" action="{{ route('admin.rumah.destroy', $item['id']) }}" onsubmit="return confirm('Hapus data rumah adat ini?')">
										@csrf
										@method('DELETE')
										<button type="submit" class="w-8 h-8 rounded-full hover:bg-[#f9eceb] text-[#c54d4d] inline-flex items-center justify-center"><i class="bi bi-trash3"></i></button>
									</form>
							</div>
						</div>

						<div class="mt-5 flex items-center justify-between text-sm text-[#6f7f72]">
							<span class="inline-flex items-center gap-2"><i class="bi bi-geo-alt"></i> {{ $item['lokasi'] }}</span>
							<span class="inline-flex items-center gap-2"><i class="bi bi-clock"></i> {{ $item['updated_at'] }}</span>
						</div>
					</div>
				</article>
			@empty
				<div class="col-span-full rounded-3xl border border-dashed border-[#d7e1d6] bg-white p-10 text-center text-[#6f7f72]">
					Tidak ada data rumah adat yang cocok dengan filter.
				</div>
			@endforelse
		</section>

		<section class="flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-black/5 pt-5">
			<p class="text-sm text-[#6f7f72]">
				Menampilkan {{ $rumah->firstItem() ?? 0 }} - {{ $rumah->lastItem() ?? 0 }} dari {{ $rumah->total() }} data
			</p>
			<div>
				{{ $rumah->links() }}
			</div>
		</section>
	</div>
@endsection
