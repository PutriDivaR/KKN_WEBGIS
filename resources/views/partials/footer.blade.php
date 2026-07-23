<footer class="bg-[#173B2E] text-white pt-14 pb-8 mt-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-10 border-b border-white/10">

            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-white/10 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5.5 h-5.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </div>
                    <p class="font-semibold text-lg leading-tight">Kampung Adat<br>Sijunjung</p>
                </div>
                <p class="text-sm text-green-100/70 mt-4 leading-relaxed max-w-[220px]">
                    Melestarikan warisan budaya untuk generasi mendatang.
                </p>
            </div>

            {{-- Navigasi --}}
            <div>
                <p class="text-sm font-semibold tracking-wide uppercase text-green-200 mb-4">Navigasi</p>
                <ul class="space-y-2.5 text-sm text-green-100/80">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('map') }}" class="hover:text-white transition-colors">Peta</a></li>
                    <li><a href="{{ route('fasilitas.index') }}" class="hover:text-white transition-colors">Fasilitas</a></li>
                    <li><a href="{{ route('perancangan.index') }}" class="hover:text-white transition-colors">Perancangan</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:text-white transition-colors">Tentang</a></li>
                </ul>
            </div>

            {{-- Contact Person --}}
            <div>
                <p class="text-sm font-semibold tracking-wide uppercase text-green-200 mb-4">Contact Person</p>
                <ul class="space-y-4 text-sm text-green-100/80">
                    <li>
                        <p class="text-white font-medium leading-tight">Wali Nagari Sijunjung</p>
                        <p class="mt-1 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            0812-3456-7890
                        </p>
                    </li>
                    <li>
                        <p class="text-white font-medium leading-tight">Ibu Dahliana</p>
                        <p class="text-green-100/60 text-xs mt-0.5">Pengelola Kampung Adat</p>
                        <p class="mt-1 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            0813-7654-3210
                        </p>
                    </li>
                    <li>
                        <p class="text-white font-medium leading-tight">Humas Kampung Adat</p>
                        <p class="mt-1 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                            0821-9988-1122
                        </p>
                    </li>
                </ul>
            </div>

            {{-- Ikuti Kami --}}
            <div>
                <p class="text-sm font-semibold tracking-wide uppercase text-green-200 mb-4">Ikuti Kami</p>
                <div class="flex items-center gap-3">
                    <a
                        href="https://instagram.com/kampungadatsijunjung"
                        target="_blank" rel="noopener" aria-label="Instagram"
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="w-4.5 h-4.5">
                            <rect x="3" y="3" width="18" height="18" rx="5" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                    <a
                        href="https://facebook.com/kampungadatsijunjung"
                        target="_blank" rel="noopener" aria-label="Facebook"
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5">
                            <path d="M13.5 21v-7.5h2.5l.5-3h-3V8.5c0-.87.24-1.5 1.53-1.5H16.5V4.35C16.06 4.24 15.03 4 13.85 4c-2.5 0-4.35 1.53-4.35 4.35V10.5H7v3h2.5V21h4z" />
                        </svg>
                    </a>
                    <a
                        href="https://www.tiktok.com/@kampungadatsijunjung"
                        target="_blank" rel="noopener" aria-label="TikTok"
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4.5 h-4.5">
                            <path d="M14 3c.3 1.9 1.6 3.4 3.5 3.8v2.7c-1.3-.1-2.5-.5-3.5-1.2v6.1c0 3-2.4 5.4-5.4 5.4S3.2 17.4 3.2 14.4c0-2.8 2.1-5.1 4.8-5.4v2.8c-1.2.2-2.1 1.3-2.1 2.6 0 1.5 1.2 2.7 2.7 2.7s2.7-1.2 2.7-2.7V3H14z" />
                        </svg>
                    </a>
                </div>
                <p class="text-xs text-green-100/50 mt-4 leading-relaxed">
                    Email: info@kampungadat.id
                </p>
            </div>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-green-100/60 text-center">
            <p>&copy; {{ date('Y') }} KKN Tematik UNAND. Seluruh hak cipta dilindungi.</p>
            <p>Kabupaten Sijunjung, Sumatera Barat</p>
        </div>
    </div>
</footer>