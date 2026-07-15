@extends('layouts.app')

@section('title', 'Fasilitas — Kampung Adat Sijunjung')

@section('content')

    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <h1 class="text-2xl md:text-3xl font-bold text-green-900">Fasilitas Kampung Adat</h1>
        <p class="mt-2 text-neutral-600 max-w-2xl">
            Temukan fasilitas yang tersedia di Kampung Adat Sijunjung.
        </p>
    </section>

    <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-24 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($fasilitas as $item)
            <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden hover:shadow-lg transition-shadow">
                <img
                    src="https://placehold.co/500x320/2f4a37/e8efe9?text={{ urlencode($item['nama']) }}"
                    alt="{{ $item['nama'] }}"
                    class="w-full h-44 object-cover"
                >
                <div class="p-5">
                    <span class="inline-block text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full">
                        {{ $item['kategori'] }}
                    </span>
                    <h3 class="font-semibold text-green-900 mt-3">{{ $item['nama'] }}</h3>
                    <p class="text-sm text-neutral-600 mt-1 leading-relaxed">{{ $item['deskripsi'] }}</p>
                    <a href="{{ route('map') }}" class="inline-block mt-4 text-sm text-green-700 font-medium hover:underline">
                        Lihat di Peta →
                    </a>
                </div>
            </div>
        @endforeach
    </section>

@endsection
