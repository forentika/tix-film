<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - TIX ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-[#1A2C50]">TIX <span class="text-[#FFBE00]">ID</span></h1>
            <p class="text-gray-500 text-sm mt-2">Masuk untuk melanjutkan pesananmu</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="admin@tix.id (untuk tes admin)" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="password123" required>
            </div>
            <button type="submit" class="w-full bg-[#1A2C50] text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
                Masuk
            </button>
        </form>
        
        <p class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun? <a href="{{ route('register') }}" class="text-[#1A2C50] font-bold">Daftar TIX ID</a>
        </p>
        <p class="mt-2 text-center text-xs text-gray-400">
            <a href="/" class="hover:underline">&larr; Kembali ke Beranda</a>
        </p>
    </div>
</body>
</html>