<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Saya - TIX ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js untuk interaksi Modal -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Josefin Sans', sans-serif; background-color: #F8F9FA; }
        .bg-tix-dark { background-color: #1A2C50; }
        .text-tix-dark { color: #1A2C50; }
        .bg-tix-gold { background-color: #FFBE00; }
        .text-tix-gold { color: #FFBE00; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="pb-24 bg-gray-50" x-data="{ showEditProfile: false, showChangePassword: false }">

    <!-- HEADER PROFILE -->
    <header class="bg-white sticky top-0 z-50 shadow-sm">
        <div class="max-w-md mx-auto px-4 h-16 flex items-center justify-center relative">
            <h1 class="font-bold text-lg text-tix-dark">Akun Saya</h1>
        </div>
    </header>

    <div class="max-w-md mx-auto min-h-screen">
        
        <!-- ALERT MESSAGES -->
        @if(session('success'))
        <div class="px-4 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline text-sm font-bold">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        
        <!-- INFO USER CARD -->
        <div class="bg-white p-6 mb-3 mt-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-gray-100">
                    <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=1A2C50&color=fff&size=128" alt="Profile" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-tix-dark leading-tight">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm mt-1">{{ $user->email }}</p>
                    <p class="text-gray-400 text-xs mt-1">Anggota sejak {{ $user->created_at->format('M Y') }}</p>
                </div>
                <!-- Tombol Edit Cepat (Memicu Modal Edit Profil) -->
                <button @click="showEditProfile = true" class="text-tix-dark hover:text-tix-gold transition">
                    <i class="fas fa-pen"></i>
                </button>
            </div>
        </div>

        <!-- MENU LIST -->
        <div class="bg-white px-4 py-2 mb-3">
            <p class="text-xs font-bold text-gray-400 mb-2 uppercase tracking-wide mt-2">Pengaturan Akun</p>
            
            <!-- TOMBOL BUKA MODAL EDIT PROFIL -->
            <button @click="showEditProfile = true" class="w-full flex items-center justify-between py-4 border-b border-gray-100 group">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-cog text-gray-400 w-6 text-center group-hover:text-tix-dark transition"></i>
                    <span class="text-gray-700 font-medium text-sm group-hover:text-tix-dark transition">Ubah Profil</span>
                </div>
                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
            </button>

            <!-- TOMBOL BUKA MODAL UBAH PASSWORD -->
            <button @click="showChangePassword = true" class="w-full flex items-center justify-between py-4 border-b border-gray-100 group">
                <div class="flex items-center gap-3">
                    <i class="fas fa-lock text-gray-400 w-6 text-center group-hover:text-tix-dark transition"></i>
                    <span class="text-gray-700 font-medium text-sm group-hover:text-tix-dark transition">Ubah Password</span>
                </div>
                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
            </button>

            <a href="#" class="flex items-center justify-between py-4 group">
                <div class="flex items-center gap-3">
                    <i class="fas fa-credit-card text-gray-400 w-6 text-center group-hover:text-tix-dark transition"></i>
                    <span class="text-gray-700 font-medium text-sm group-hover:text-tix-dark transition">Metode Pembayaran</span>
                </div>
                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
            </a>
        </div>

        <!-- INFO LAINNYA -->
        <div class="bg-white px-4 py-2 mb-6">
            <p class="text-xs font-bold text-gray-400 mb-2 uppercase tracking-wide mt-2">Info Lainnya</p>
            
            <a href="#" class="flex items-center justify-between py-4 border-b border-gray-100 group">
                <div class="flex items-center gap-3">
                    <i class="fas fa-question-circle text-gray-400 w-6 text-center group-hover:text-tix-dark transition"></i>
                    <span class="text-gray-700 font-medium text-sm group-hover:text-tix-dark transition">Pusat Bantuan</span>
                </div>
                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
            </a>

            <a href="#" class="flex items-center justify-between py-4 group">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-alt text-gray-400 w-6 text-center group-hover:text-tix-dark transition"></i>
                    <span class="text-gray-700 font-medium text-sm group-hover:text-tix-dark transition">Kebijakan Privasi</span>
                </div>
                <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
            </a>
        </div>

        <!-- LOGOUT BUTTON -->
        <div class="px-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-white border border-red-500 text-red-500 font-bold py-3 rounded-xl hover:bg-red-50 transition shadow-sm">
                    Keluar
                </button>
            </form>
            <p class="text-center text-xs text-gray-400 mt-4 mb-8">Versi Aplikasi 2.4.0</p>
        </div>

    </div>

    <!-- MODAL EDIT PROFILE -->
    <div x-show="showEditProfile" x-cloak class="fixed inset-0 z-[60] flex items-end sm:items-center justify-center bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white w-full max-w-md rounded-t-2xl sm:rounded-2xl p-6 relative" 
             @click.outside="showEditProfile = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform translate-y-full sm:translate-y-10 sm:scale-95"
             x-transition:enter-end="transform translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="transform translate-y-0 sm:scale-100"
             x-transition:leave-end="transform translate-y-full sm:translate-y-10 sm:scale-95">
             
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-tix-dark">Ubah Profil</h3>
                <button @click="showEditProfile = false" class="text-gray-400 hover:text-tix-dark">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-tix-dark focus:ring-1 focus:ring-tix-dark text-sm" placeholder="Nama Lengkap">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-tix-dark focus:ring-1 focus:ring-tix-dark text-sm" placeholder="email@contoh.com">
                </div>

                <button type="submit" class="w-full bg-tix-dark text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <!-- MODAL UBAH PASSWORD -->
    <div x-show="showChangePassword" x-cloak class="fixed inset-0 z-[60] flex items-end sm:items-center justify-center bg-black/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white w-full max-w-md rounded-t-2xl sm:rounded-2xl p-6 relative" 
             @click.outside="showChangePassword = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform translate-y-full sm:translate-y-10 sm:scale-95"
             x-transition:enter-end="transform translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="transform translate-y-0 sm:scale-100"
             x-transition:leave-end="transform translate-y-full sm:translate-y-10 sm:scale-95">
             
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-tix-dark">Ubah Password</h3>
                <button @click="showChangePassword = false" class="text-gray-400 hover:text-tix-dark">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('user.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-tix-dark focus:ring-1 focus:ring-tix-dark text-sm" placeholder="Masukkan password lama">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password Baru</label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-tix-dark focus:ring-1 focus:ring-tix-dark text-sm" placeholder="Minimal 8 karakter">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-tix-dark focus:ring-1 focus:ring-tix-dark text-sm" placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="w-full bg-tix-dark text-white font-bold py-3 rounded-lg hover:opacity-90 transition">
                    Ubah Password
                </button>
            </form>
        </div>
    </div>

    <!-- BOTTOM NAVIGATION -->
    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-50">
        <div class="max-w-md mx-auto grid grid-cols-3 h-16">
            <a href="{{ route('user.home') }}" class="flex flex-col items-center justify-center text-gray-400 hover:text-tix-dark transition group">
                <i class="fas fa-home text-xl mb-1 group-hover:scale-110 transition"></i>
                <span class="text-[10px] font-medium tracking-wide">Beranda</span>
            </a>
            
            <a href="{{ route('tickets.index') }}" class="flex flex-col items-center justify-center text-gray-400 hover:text-tix-dark transition group">
                <i class="fas fa-ticket-alt text-xl mb-1 group-hover:scale-110 transition"></i>
                <span class="text-[10px] font-medium tracking-wide">Tiket Saya</span>
            </a>
            
            <a href="{{ route('user.profile') }}" class="flex flex-col items-center justify-center text-tix-dark transition">
                <i class="fas fa-user text-xl mb-1 scale-110"></i>
                <span class="text-[10px] font-bold tracking-wide">Akun</span>
            </a>
        </div>
    </nav>

</body>
</html>