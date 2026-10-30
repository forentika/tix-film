<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIX ID - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { 
            font-family: 'Josefin Sans', sans-serif; 
            background-color: #F8F9FA;
        }
        .bg-tix-dark { background-color: #1A2C50; }
        .text-tix-dark { color: #1A2C50; }
        .bg-tix-gold { background-color: #FFBE00; }
        .text-tix-gold { color: #FFBE00; }
        
        /* Hide Scrollbar */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* Hover Effect */
        .movie-card:hover .buy-ticket-btn {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="pb-24">

    <header class="bg-white sticky top-0 z-50 shadow-sm" x-data="{ openCity: false }">
    <div class="max-w-md mx-auto px-4 h-16 flex items-center justify-between">
        <div class="flex-1 mr-4 bg-gray-100 rounded-full flex items-center px-4 py-2">
            <i class="fas fa-search text-gray-400 text-sm"></i>
            <input type="text" placeholder="Cari di TIX ID" class="bg-transparent border-none focus:outline-none text-sm ml-2 w-full text-gray-700 font-medium placeholder-gray-400">
        </div>

        <div class="flex items-center gap-4">
            <button class="relative">
                <i class="far fa-bell text-2xl text-tix-dark"></i>
                <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            
            <!-- UPDATE: Link ke halaman Profile -->
            <a href="{{ route('user.profile') }}" class="w-8 h-8 rounded-full overflow-hidden border border-gray-200 block">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=1A2C50&color=fff" alt="Profile" class="w-full h-full object-cover">
            </a>
            <!-- END UPDATE -->

        </div>
    </div>
    
    <div class="bg-white border-b border-gray-100 relative">
        <div @click="openCity = !openCity" class="max-w-md mx-auto px-4 py-2 flex items-center text-tix-dark cursor-pointer hover:bg-gray-50 transition">
            <i class="fas fa-map-marker-alt mr-2 text-lg"></i>
            <span class="font-bold text-sm tracking-wide uppercase">{{ $currentCity }}</span>
            <i class="fas fa-chevron-down ml-1 text-xs text-gray-400 transition-transform" :class="openCity ? 'rotate-180' : ''"></i>
        </div>

        <div x-show="openCity" @click.outside="openCity = false" class="absolute w-full bg-white shadow-lg border-t z-40 max-h-60 overflow-y-auto" style="display: none;">
            <div class="max-w-md mx-auto">
                <p class="px-4 py-2 text-xs text-gray-400 bg-gray-50 font-bold">PILIH KOTA</p>
                @foreach($cities as $city)
                <button class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 border-b border-gray-100 uppercase font-medium flex justify-between items-center group">
                    {{ $city }}
                    @if($city == $currentCity)
                        <i class="fas fa-check text-tix-dark"></i>
                    @endif
                </button>
                @endforeach
                @if($cities->isEmpty())
                    <p class="px-4 py-3 text-sm text-gray-400 italic">Belum ada data bioskop.</p>
                @endif
            </div>
        </div>
    </div>
</header>


    <div class="max-w-md mx-auto">
        
        <div class="mt-4 px-4">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-tix-dark text-lg leading-tight">TIX VIP</h3>
                    <p class="text-xs text-gray-500 mt-1">Dapatkan keuntungan eksklusif!</p>
                </div>
                <button class="bg-tix-dark text-white px-4 py-1.5 rounded-full text-xs font-bold tracking-wider">GABUNG</button>
            </div>
        </div>

        <div class="mt-8">
            <div class="px-4 flex justify-between items-end mb-4">
                <h2 class="text-xl font-bold text-tix-dark">Sedang Tayang</h2>
                <a href="#" class="text-sm font-bold text-tix-dark hover:text-tix-gold transition">Semua ></a>
            </div>

            <div class="flex overflow-x-auto gap-4 px-4 pb-6 scrollbar-hide snap-x">
                @forelse($movies as $movie)
                <div class="flex-shrink-0 w-40 snap-center group movie-card relative cursor-pointer">
                    <a href="{{ route('movie.show', $movie->id) }}" class="block">
                        <div class="relative rounded-xl overflow-hidden shadow-md h-60 bg-gray-200">
                            <img src="{{ asset('storage/' . $movie->poster) }}" class="w-full h-full object-cover">
                            
                            <div class="absolute top-2 right-2 bg-tix-dark/80 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-0.5 rounded-md">
                                {{ $movie->age_rating }}
                            </div>

                            <div class="buy-ticket-btn absolute bottom-0 left-0 w-full p-3 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 flex justify-center bg-gradient-to-t from-black/80 to-transparent">
                                <span class="w-full bg-tix-dark text-white text-center py-2 rounded-lg text-xs font-bold shadow-lg hover:bg-blue-900 transition border border-gray-600 block">
                                    BUY TICKET
                                </span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('movie.show', $movie->id) }}" class="block mt-3 text-center group-hover:text-blue-900 transition">
                        <h3 class="font-bold text-tix-dark text-base truncate px-1">{{ $movie->title }}</h3>
                        <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $movie->genre }}</p>
                    </a>
                </div>
                @empty
                <div class="w-full text-center py-10 text-gray-400 text-sm">Belum ada film tayang.</div>
                @endforelse
            </div>
        </div>

        <div class="mt-2 border-t border-gray-200 pt-6">
            <div class="px-4 flex justify-between items-end mb-4">
                <h2 class="text-xl font-bold text-tix-dark">TIX Events & Promo</h2>
                <a href="#" class="text-sm font-bold text-tix-dark hover:text-tix-gold transition">Semua ></a>
            </div>

            <div class="flex overflow-x-auto gap-4 px-4 pb-4 scrollbar-hide snap-x">
                @forelse($banners as $promo)
                <div class="flex-shrink-0 w-80 snap-center rounded-xl overflow-hidden shadow-sm relative group cursor-pointer">
                    <img src="{{ asset('storage/' . $promo->banner) }}" class="w-full h-40 object-cover transition transform group-hover:scale-105 duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex flex-col justify-end p-4">
                        <h4 class="text-white font-bold text-lg leading-tight shadow-black drop-shadow-md">{{ $promo->title }}</h4>
                        <p class="text-gray-200 text-xs mt-1 truncate">{{ $promo->description }}</p>
                    </div>
                </div>
                @empty
                <div class="w-full px-4 text-center py-4 text-gray-400 text-xs">Belum ada promo aktif.</div>
                @endforelse
            </div>
        </div>

        <div class="mt-6 border-t border-gray-200 pt-6 pb-6">
            <div class="px-4 flex justify-between items-end mb-4">
                <h2 class="text-xl font-bold text-tix-dark">Akan Datang</h2>
                <a href="#" class="text-sm font-bold text-tix-dark hover:text-tix-gold transition">Semua ></a>
            </div>

            <div class="flex overflow-x-auto gap-4 px-4 pb-6 scrollbar-hide snap-x">
                @forelse($comingSoon as $cs)
                <div class="flex-shrink-0 w-32 snap-center">
                    <div class="relative rounded-lg overflow-hidden shadow-sm h-48 bg-gray-200 mb-2 grayscale hover:grayscale-0 transition duration-500 cursor-pointer">
                        <img src="{{ asset('storage/' . $cs->poster) }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 w-full bg-black/70 backdrop-blur-sm text-white text-[9px] text-center py-1.5 font-bold tracking-widest border-t border-gray-600">
                            COMING SOON
                        </div>
                    </div>
                    <h3 class="font-bold text-tix-dark text-xs truncate mt-2">{{ $cs->title }}</h3>
                    <p class="text-[10px] text-gray-400 truncate">{{ $cs->genre }}</p>
                </div>
                @empty
                <div class="w-full text-center py-6 text-gray-400 text-sm italic">
                    Belum ada film yang akan datang.
                </div>
                @endforelse
            </div>
        </div>

    </div>

    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-50">
        <div class="max-w-md mx-auto grid grid-cols-3 h-16">
            <a href="{{ route('user.home') }}" class="flex flex-col items-center justify-center text-tix-dark transition">
                <i class="fas fa-home text-xl mb-1"></i>
                <span class="text-[10px] font-bold tracking-wide">Beranda</span>
            </a>
            
            <a href="{{ route('tickets.index') }}" class="flex flex-col items-center justify-center text-gray-400 hover:text-tix-dark transition">
                <i class="fas fa-ticket-alt text-xl mb-1"></i>
                <span class="text-[10px] font-medium tracking-wide">Tiket Saya</span>
            </a>
            
        <a href="{{ route('user.profile') }}" class="flex flex-col items-center justify-center text-gray-400 hover:text-tix-dark transition">
                <i class="fas fa-user text-xl mb-1"></i>
                <span class="text-[10px] font-medium tracking-wide">Akun</span>
            </a>
        </div>
    </nav>

</body>
</html>