@extends('layouts.app')

@section('title', 'Tentang — WebGIS Kampung Adat Sijunjung')

@section('content')

<section class="bg-white py-14">

    <div class="max-w-7xl mx-auto px-6">

        {{-- HEADER --}}
        <div class="text-center mb-12">

            <h1 class="text-4xl font-bold text-gray-800">
                Tentang Kampung Adat Sijunjung
            </h1>

            <div class="w-20 h-1 bg-green-600 rounded-full mx-auto mt-4 mb-5"></div>

            <p class="max-w-2xl mx-auto text-gray-500 leading-7">
                Kampung Adat Sijunjung merupakan salah satu warisan budaya
                Minangkabau yang masih menjaga tradisi dan kearifan lokal
                melalui rumah gadang, adat istiadat, serta kehidupan masyarakat
                yang tetap lestari hingga saat ini.
            </p>

        </div>



        {{-- CONTENT --}}
        <div class="grid lg:grid-cols-12 gap-7">

            {{-- KIRI --}}
            <div class="lg:col-span-6 space-y-6">

                {{-- SEJARAH --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-7">

                    <div class="flex items-center gap-3 mb-5">

                        <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-green-700"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3"/>

                            </svg>

                        </div>

                        <h2 class="font-semibold text-green-900 text-lg">
                            {{ $tentang['judul_sejarah'] }}
                        </h2>

                    </div>

                    <div class="space-y-4 text-gray-600 leading-8 text-justify">

                        <p>
                            {{ $tentang['isi_sejarah'] }}
                        </p>

                        <p>
                            Kawasan ini berkembang sebagai pusat kehidupan
                            masyarakat adat yang tetap mempertahankan sistem
                            kekerabatan matrilineal, rumah gadang sebagai
                            identitas budaya, serta musyawarah adat sebagai
                            bagian dari kehidupan sehari-hari.
                        </p>

                        <p>
                            Hingga kini Kampung Adat Sijunjung menjadi salah satu
                            destinasi wisata budaya di Sumatera Barat yang tetap
                            menjaga keaslian arsitektur tradisional dan nilai
                            budaya Minangkabau.
                        </p>

                    </div>

                </div>



                {{-- WEBSITE --}}
                <div class="bg-green-50 rounded-3xl border border-green-100 p-7">

                    <div class="flex items-center gap-3 mb-4">

                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-green-700"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 12.79A9 9 0 1111.21 3"/>

                            </svg>

                        </div>

                        <h3 class="font-semibold text-green-900">
                            Tentang Website
                        </h3>

                    </div>

                    <p class="text-gray-600 leading-7">

                        Website Kampung Adat Sijunjung dikembangkan
                        sebagai media informasi digital yang memudahkan masyarakat
                        dan wisatawan memperoleh informasi mengenai rumah adat,
                        fasilitas, sejarah, serta lokasi penting dalam kawasan
                        Kampung Adat Sijunjung.

                    </p>

                </div>

            </div>




            {{-- KANAN --}}
            <div class="lg:col-span-6 space-y-6">

                {{-- FOTO --}}
                <div class="overflow-hidden rounded-3xl shadow-sm">

                    {{-- GANTI DENGAN FOTO ASLI --}}
                    <img src="{{ asset('assets/wallpaper_beranda.jpeg') }}"
                        class="w-full h-[330px] object-cover"  >

                </div>



                {{-- NILAI --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-7">

                    <h2 class="text-lg font-semibold text-green-900 mb-6">
                        Nilai dan Keunikan Kampung Adat Sijunjung
                    </h2>

                    <div class="space-y-6">

                        <div class="flex gap-4">

                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-700"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"/>

                                </svg>

                            </div>

                            <div>

                                <h3 class="font-semibold text-gray-800">
                                    Warisan Budaya Minangkabau
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Kawasan budaya yang masih mempertahankan
                                    rumah gadang, adat, dan tradisi turun-temurun.
                                </p>

                            </div>

                        </div>



                        <div class="flex gap-4">

                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-700"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8c-2.21 0-4 1.79-4 4"/>

                                </svg>

                            </div>

                            <div>

                                <h3 class="font-semibold text-gray-800">
                                    Sistem Matrilineal
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Nilai kekerabatan masyarakat diwariskan
                                    berdasarkan garis keturunan ibu.
                                </p>

                            </div>

                        </div>



                        <div class="flex gap-4">

                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-700"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 17l4 4 4-4m0-5l-4-4-4 4"/>

                                </svg>

                            </div>

                            <div>

                                <h3 class="font-semibold text-gray-800">
                                    Arsitektur Rumah Gadang
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Memiliki bentuk khas dengan atap gonjong
                                    sebagai identitas budaya Minangkabau.
                                </p>

                            </div>

                        </div>



                        <div class="flex gap-4">

                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-green-700"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 6v12"/>

                                </svg>

                            </div>

                            <div>

                                <h3 class="font-semibold text-gray-800">
                                    Destinasi Wisata Budaya
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Menjadi salah satu kawasan cagar budaya
                                    unggulan di Kabupaten Sijunjung.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection