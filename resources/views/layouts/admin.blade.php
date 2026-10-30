<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - TIX ID</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Inter (Mirip font modern aplikasi) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-tix-dark { background-color: #1A2C50; } /* TIX ID Navy */
        .bg-tix-darker { background-color: #0f1d38; } /* Darker Navy for Hover */
        .text-tix-gold { color: #FFBE00; } /* TIX ID Gold */
        .border-tix-gold { border-color: #FFBE00; }
        
        /* Hide Scrollbar for Sidebar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR -->
        <aside class="w-64 bg-tix-dark text-white flex-shrink-0 hidden md:flex flex-col transition-all duration-300">
            <!-- Logo Area -->
            <div class="h-16 flex items-center justify-center border-b border-gray-700 shadow-sm">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1">
                    <span class="text-3xl font-bold tracking-tighter">TIX</span>
                    <span class="text-3xl font-bold text-tix-gold tracking-tighter">ID</span>
                    <span class="ml-2 text-xs bg-gray-700 px-2 py-0.5 rounded text-gray-300">ADMIN</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto no-scrollbar py-4">
                <nav class="space-y-1 px-2">
                    
                    <!-- Dashboard -->
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">Main</p>
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-tix-darker text-white border-l-4 border-tix-gold' : 'text-gray-300 hover:bg-tix-darker hover:text-white' }}">
                        <i class="fas fa-chart-pie mr-3 text-lg {{ request()->routeIs('admin.dashboard') ? 'text-tix-gold' : 'text-gray-400' }}"></i>
                        Dashboard
                    </a>

                    <!-- Movie Management -->
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Film & Konten</p>
                    <a href="{{ route('movies.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-tix-darker hover:text-white transition-colors">
                        <i class="fas fa-film mr-3 text-lg text-gray-400 group-hover:text-tix-gold"></i>
                        Data Film (Movies)
                    </a>
                    <a href="{{ route('spotlights.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('spotlights.*') ? 'bg-tix-darker text-white border-l-4 border-tix-gold' : 'text-gray-300 hover:bg-tix-darker hover:text-white' }} transition-colors">
                     <i class="fas fa-star mr-3 text-lg {{ request()->routeIs('spotlights.*') ? 'text-tix-gold' : 'text-gray-400' }} group-hover:text-tix-gold"></i>
                        Spotlight & Promo
                    </a>

                    <!-- Cinema Management -->
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Bioskop & Jadwal</p>
                    <a href="{{ route('cinemas.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-tix-darker hover:text-white transition-colors">
    <i class="fas fa-building mr-3 text-lg group-hover:text-tix-gold"></i>
    Kelola Bioskop
</a>
                    <a href="{{ route('studios.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-tix-darker hover:text-white transition-colors">
    <i class="fas fa-couch mr-3 text-lg group-hover:text-tix-gold"></i>
    Kelola Studio
</a>
                   <a href="{{ route('showtimes.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('showtimes.*') ? 'bg-tix-darker text-white border-l-4 border-tix-gold' : 'text-gray-300 hover:bg-tix-darker hover:text-white' }} transition-colors">
    <i class="fas fa-calendar-alt mr-3 text-lg {{ request()->routeIs('showtimes.*') ? 'text-tix-gold' : 'text-gray-400' }} group-hover:text-tix-gold"></i>
    Atur Jadwal (Schedule)
</a>

                    <!-- Transactions -->
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Transaksi</p>
                    <a href="{{ route('admin.transactions.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md {{ request()->routeIs('admin.transactions.*') ? 'bg-tix-darker text-white border-l-4 border-tix-gold' : 'text-gray-300 hover:bg-tix-darker hover:text-white' }} transition-colors">
    <i class="fas fa-receipt mr-3 text-lg {{ request()->routeIs('admin.transactions.*') ? 'text-tix-gold' : 'text-gray-400' }} group-hover:text-tix-gold"></i>
    Riwayat Pemesanan
</a>
                   <a href="{{ route('users.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-md text-gray-300 hover:bg-tix-darker hover:text-white transition-colors {{ request()->routeIs('users.*') ? 'bg-tix-darker text-white' : '' }}">
    <i class="fas fa-users mr-3 text-lg text-gray-400 group-hover:text-tix-gold {{ request()->routeIs('users.*') ? 'text-tix-gold' : '' }}"></i>
    Data Pengguna
</a>
                </nav>
            </div>

            <!-- Footer Sidebar -->
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gray-500 flex items-center justify-center text-white text-xs font-bold">
                        AD
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT WRAPPER -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- HEADER -->
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
                <!-- Left: Title / Breadcrumb / Mobile Toggle -->
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-800 tracking-tight">
                        @yield('title', 'Dashboard')
                    </h2>
                </div>

                <!-- Right: Utilities -->
                <div class="flex items-center gap-4">
                    <!-- Notification Bell -->
                    <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- Divider -->
                    <div class="h-6 w-px bg-gray-300"></div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-sm font-medium text-red-600 hover:text-red-800 transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- CONTENT SCROLLABLE AREA -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Content Injection -->
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>