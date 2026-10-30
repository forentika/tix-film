<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - TIX ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen py-10">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-[#1A2C50]">TIX <span class="text-[#FFBE00]">ID</span></h1>
            <p class="text-gray-500 text-sm mt-2">Daftar sekarang untuk mulai memesan tiket</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="contoh@email.com" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Minimal 8 karakter" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="w-full bg-[#1A2C50] text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
                Daftar Akun
            </button>
        </form>
        
        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-[#1A2C50] font-bold">Masuk disini</a>
        </p>
        <p class="mt-2 text-center text-xs text-gray-400">
            <a href="/" class="hover:underline">&larr; Kembali ke Beranda</a>
        </p>
    </div>
</body>
</html>