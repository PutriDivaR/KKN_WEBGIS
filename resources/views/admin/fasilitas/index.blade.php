@extends('layouts.admin')

@section('title', 'Kelola Fasilitas - Admin Kampung Adat')
@section('eyebrow', 'Manajemen Aset Desa')
@section('page_title', 'Daftar Fasilitas')
@section('meta_description', 'Kelola data fasilitas publik di wilayah Jorong Kampung Adat Sijunjung.')

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <form method="GET" action="{{ route('admin.fasilitas.index') }}" class="w-full sm:max-w-sm">
            <label class="flex items-center gap-2 h-11 px-4 rounded-full bg-[#edf3ea] text-[#6d7f72] border border-transparent focus-within:border-[#b8c7b7]">
                <i class="bi bi-search"></i>
                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama fasilitas..."
                    onchange="this.form.submit()"
                    class="w-full bg-transparent outline-none text-sm placeholder:text-[#8b9a8f]"
                >
            </label>
        </form>

        <a href="{{ route('admin.fasilitas.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-[#2f5a36] hover:bg-[#244529] text-white text-sm font-medium px-5 h-11 rounded-full shadow-sm transition shrink-0">
            <i class="bi bi-plus-lg"></i>
            Tambah Fasilitas
        </a>
    </div>

    @if ($fasilitas->isEmpty())
        <div class="bg-white rounded-2xl border border-[#e5ece3] py-16 text-center text-[#8b9a8f]">
            @if ($search !== '')
                Tidak ada fasilitas yang cocok dengan pencarian "{{ $search }}".
            @else
                Belum ada data fasilitas. Klik "Tambah Fasilitas" untuk menambahkan.
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($fasilitas as $item)
                @php
                    $kategoriStyle = match ($item->kategori) {
                        'Pendidikan'      => 'text-blue-700',
                        'Pusat Informasi' => 'text-purple-700',
                        'Umum'            => 'text-[#2f5a36]',
                        default           => 'text-[#8b9a8f]',
                    };
                @endphp

                <div class="bg-white rounded-2xl shadow-sm border border-[#e5ece3] overflow-hidden flex flex-col">
                    {{-- Foto --}}
                    <div class="relative aspect-video bg-[#edf3ea]">
                        @if ($item->cover_photo)
                            <img src="{{ $item->cover_photo }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-[#a9b8ac] gap-1">
                                <i class="bi bi-image text-2xl"></i>
                                <span class="text-xs">Belum ada foto</span>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="p-5 flex flex-col flex-1">
                        <p class="text-xs font-semibold uppercase tracking-wide {{ $kategoriStyle }} mb-1">
                            {{ $item->kategori ?? 'Belum dikategorikan' }}
                        </p>
                        <h3 class="font-semibold text-[#132018] leading-snug mb-1.5">
                            {{ $item->nama }}
                        </h3>
                        <p class="flex items-center gap-1.5 text-xs text-[#56715d] mb-4">
                            <i class="bi bi-geo-alt"></i>
                            {{ $item->jorong->nama_jorong ?? 'Jorong belum diatur' }}
                        </p>

                        <div class="border-t border-[#e5ece3] pt-4 mt-auto flex items-center gap-2">
                            <button type="button"
                                    onclick="document.getElementById('detail-{{ $item->id_fasilitas }}').showModal()"
                                    class="w-9 h-9 rounded-full border border-[#d9e3d8] text-[#4d6150] hover:bg-[#edf3ea] flex items-center justify-center" title="Lihat detail">
                                <i class="bi bi-eye"></i>
                            </button>
                            <a href="{{ route('admin.fasilitas.edit', $item->id_fasilitas) }}"
                               class="w-9 h-9 rounded-full border border-[#d9e3d8] text-[#4d6150] hover:bg-[#edf3ea] flex items-center justify-center" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.fasilitas.destroy', $item->id_fasilitas) }}" method="POST"
                                  onsubmit="return confirm('Hapus fasilitas &quot;{{ $item->nama }}&quot;? Semua foto terkait juga akan dihapus.');"
                                  class="ml-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-9 h-9 rounded-full border border-red-100 text-red-500 hover:bg-red-50 flex items-center justify-center" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Modal detail (native <dialog>, tanpa route/JS framework tambahan) --}}
                <dialog id="detail-{{ $item->id_fasilitas }}" class="m-auto rounded-2xl w-full max-w-lg p-0 backdrop:bg-black/50">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide {{ $kategoriStyle }} mb-1">
                                    {{ $item->kategori ?? 'Belum dikategorikan' }}
                                </p>
                                <h3 class="font-semibold text-[#132018] text-lg">{{ $item->nama }}</h3>
                            </div>
                            <button type="button" onclick="document.getElementById('detail-{{ $item->id_fasilitas }}').close()"
                                    class="text-[#8b9a8f] hover:text-[#4d6150]">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        @if ($item->media->isNotEmpty())
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                @foreach ($item->media as $media)
                                    <img src="{{ $media->url }}" class="aspect-video w-full object-cover rounded-lg border border-[#e5ece3]">
                                @endforeach
                            </div>
                        @endif

                        <dl class="text-sm space-y-2">
                            <div class="flex justify-between gap-4">
                                <dt class="text-[#56715d]">Jorong</dt>
                                <dd class="text-[#132018] text-right">{{ $item->jorong->nama_jorong ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="text-[#56715d]">Koordinat</dt>
                                <dd class="text-[#132018] text-right">
                                    @if ($item->latitude && $item->longitude)
                                        {{ number_format($item->latitude, 6) }}, {{ number_format($item->longitude, 6) }}
                                    @else
                                        Belum diatur
                                    @endif
                                </dd>
                            </div>
                            @if ($item->deskripsi)
                                <div>
                                    <dt class="text-[#56715d] mb-1">Deskripsi</dt>
                                    <dd class="text-[#374b3a] leading-relaxed">{{ $item->deskripsi }}</dd>
                                </div>
                            @endif
                        </dl>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.fasilitas.edit', $item->id_fasilitas) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#2f5a36] hover:bg-[#244529] text-white text-sm font-medium">
                                Edit Fasilitas
                            </a>
                        </div>
                    </div>
                </dialog>
            @endforeach
        </div>

        <div class="flex items-center justify-between mt-8">
            <p class="text-sm text-[#56715d]">
                Menampilkan {{ $fasilitas->count() }} dari {{ $fasilitas->total() }} fasilitas
            </p>
            <div class="flex gap-2">
                <a href="{{ $fasilitas->previousPageUrl() ?? '#' }}"
                   class="px-4 py-2 rounded-full border border-[#d9e3d8] text-sm font-medium {{ $fasilitas->onFirstPage() ? 'text-[#c3cec5] pointer-events-none' : 'text-[#132018] hover:bg-[#edf3ea]' }}">
                    Previous
                </a>
                <a href="{{ $fasilitas->hasMorePages() ? $fasilitas->nextPageUrl() : '#' }}"
                   class="px-4 py-2 rounded-full text-sm font-medium {{ $fasilitas->hasMorePages() ? 'bg-[#2f5a36] text-white hover:bg-[#244529]' : 'bg-[#edf3ea] text-[#c3cec5] pointer-events-none' }}">
                    Next
                </a>
            </div>
        </div>
    @endif
@endsection
