<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Kampung Adat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-[#e7efe4] via-[#f4f6f2] to-[#d9e8d0] font-sans text-[#132018] flex items-center justify-center p-6">
    <div class="w-full max-w-md rounded-3xl bg-white/90 backdrop-blur border border-white shadow-2xl p-8">
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-full bg-[#0b442a] text-white flex items-center justify-center overflow-hidden shadow-lg">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-12 h-12 object-contain">
            </div>
            <h1 class="mt-5 text-2xl font-semibold">Login Admin</h1>
            <p class="mt-2 text-sm text-[#6f7f72]">Masuk untuk mengelola data rumah adat dan fasilitas.</p>
        </div>

        <form method="POST" action="{{ route('admin.login') }}" class="mt-8 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-2" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full h-12 rounded-xl border border-[#d7e1d6] px-4 outline-none focus:border-[#0b442a]" placeholder="admin@kampungadat.id">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2" for="password">Password</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required class="w-full h-12 rounded-xl border border-[#d7e1d6] px-4 pr-12 outline-none focus:border-[#0b442a]" placeholder="••••••••">
                    <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 px-4 text-[#6f7f72] hover:text-[#0b442a]" aria-label="Tampilkan atau sembunyikan password">
                        <i class="bi bi-eye" id="toggle-password-icon"></i>
                    </button>
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm text-[#6f7f72]">
                <input type="checkbox" name="remember" class="rounded border-[#cfd9cd] text-[#0b442a] focus:ring-[#0b442a]">
                Ingat saya
            </label>

            <button type="submit" class="w-full h-12 rounded-xl bg-[#0b442a] text-white font-semibold hover:bg-[#0f5331]">Masuk</button>
        </form>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('toggle-password');
        const toggleIcon = document.getElementById('toggle-password-icon');

        toggleButton?.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleIcon.classList.toggle('bi-eye', !isPassword);
            toggleIcon.classList.toggle('bi-eye-slash', isPassword);
        });
    </script>
</body>
</html>