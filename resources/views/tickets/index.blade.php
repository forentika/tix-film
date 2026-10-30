<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Saya - TIX ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Josefin Sans', sans-serif; background-color: #F8F9FA; }
        .bg-tix-dark { background-color: #1A2C50; }
        .text-tix-dark { color: #1A2C50; }
        .bg-tix-gold { background-color: #FFBE00; }
        .text-tix-gold { color: #FFBE00; }
        
        /* Dashed Line untuk tiket */
        .ticket-dash {
            border-top: 2px dashed #e5e7eb;
            position: relative;
        }
        .ticket-dash::before, .ticket-dash::after {
            content: '';
            position: absolute;
            top: -10px;
            width: 20px;
            height: 20px;
            background-color: #F8F9FA;
            border-radius: 50%;
        }
        .ticket-dash::before { left: -10px; }
        .ticket-dash::after { right: -10px; }
    </style>
</head>
<body class="pb-24">

    <header class="bg-white sticky top-0 z-50 shadow-sm">
        <div class="max-w-md mx-auto px-4 h-16 flex items-center justify-center relative">
            <h1 class="font-bold text-lg text-tix-dark">Tiket Bioskop</h1>
        </div>
    </header>

    <div class="max-w-md mx-auto bg-gray-50 min-h-screen" x-data="{ activeTab: 'upcoming', showQr: false, currentCode: '' }">
        
        <div class="bg-white px-4 pt-2">
            <div class="flex border-b border-gray-200">
                <button 
                    @click="activeTab = 'upcoming'" 
                    class="flex-1 py-3 text-sm font-bold text-center transition relative"
                    :class="activeTab === 'upcoming' ? 'text-tix-dark' : 'text-gray-400'"
                >
                    AKTIF
                    <div x-show="activeTab === 'upcoming'" class="absolute bottom-0 left-0 w-full h-1 bg-tix-dark rounded-t-full"></div>
                </button>
                <button 
                    @click="activeTab = 'past'" 
                    class="flex-1 py-3 text-sm font-bold text-center transition relative"
                    :class="activeTab === 'past' ? 'text-tix-dark' : 'text-gray-400'"
                >
                    RIWAYAT
                    <div x-show="activeTab === 'past'" class="absolute bottom-0 left-0 w-full h-1 bg-tix-dark rounded-t-full"></div>
                </button>
            </div>
        </div>

        <div x-show="activeTab === 'upcoming'" class="p-4 space-y-4">
            @forelse($upcomingTickets as $ticket)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden" @click="showQr = true; currentCode = '{{ $ticket->booking_code }}'">
                <div class="p-4 flex gap-4">
                    <img src="{{ asset('storage/' . $ticket->showtime->movie->poster) }}" class="w-20 h-28 object-cover rounded-lg shadow-sm">
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-tix-dark text-base leading-tight">{{ $ticket->showtime->movie->title }}</h3>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded font-bold">{{ $ticket->showtime->movie->age_rating }}</span>
                                <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-0.5 rounded font-bold">{{ $ticket->showtime->studio->type }}</span>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">
                            <p class="font-bold text-tix-dark">{{ $ticket->showtime->studio->cinema->name }}</p>
                            <p class="mt-0.5">{{ $ticket->showtime->start_time->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="ticket-dash"></div>

                <div class="p-3 flex justify-between items-center bg-white">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-ticket-alt text-green-500 text-sm"></i>
                        <span class="text-xs font-bold text-gray-600">{{ count($ticket->seats) }} Tiket</span>
                    </div>
                    <div class="flex items-center gap-1 cursor-pointer">
                        <span class="text-xs font-bold text-tix-dark">Kode Booking: {{ $ticket->booking_code }}</span>
                        <i class="fas fa-qrcode text-tix-dark ml-2"></i>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-20 text-gray-400">
                <i class="fas fa-ticket-alt text-6xl mb-4 text-gray-300"></i>
                <h3 class="font-bold text-gray-600">Belum ada tiket aktif</h3>
                <p class="text-xs mt-1">Ayo pesan tiket bioskop sekarang!</p>
                <a href="{{ route('user.home') }}" class="mt-4 bg-tix-dark text-white px-6 py-2 rounded-full text-xs font-bold">CARI FILM</a>
            </div>
            @endforelse
        </div>

        <div x-show="activeTab === 'past'" class="p-4 space-y-4" style="display: none;">
            @forelse($pastTickets as $ticket)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden opacity-75 grayscale hover:grayscale-0 transition">
                <div class="p-4 flex gap-4">
                    <img src="{{ asset('storage/' . $ticket->showtime->movie->poster) }}" class="w-16 h-24 object-cover rounded-lg">
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-700 text-sm leading-tight">{{ $ticket->showtime->movie->title }}</h3>
                        <p class="text-[10px] text-gray-500 mt-1">{{ $ticket->showtime->start_time->format('d M Y, H:i') }}</p>
                        <p class="text-[10px] font-bold text-gray-600 mt-1">{{ $ticket->showtime->studio->cinema->name }}</p>
                        <div class="mt-3">
                            <span class="bg-gray-200 text-gray-600 text-[10px] px-2 py-1 rounded font-bold">SELESAI</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-10 text-gray-400 text-sm">Belum ada riwayat nonton.</div>
            @endforelse
        </div>

        <div x-show="showQr" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4" style="display: none;">
            <div class="bg-white rounded-2xl w-full max-w-sm p-6 text-center relative" @click.outside="showQr = false">
                <button @click="showQr = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
                
                <h3 class="font-bold text-tix-dark text-lg mb-1">Scan QR Code</h3>
                <p class="text-xs text-gray-500 mb-6">Tunjukkan ke petugas bioskop untuk cetak tiket</p>
                
                <div class="flex justify-center mb-4">
                    <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' + currentCode" class="w-48 h-48">
                </div>
                
                <p class="font-bold text-xl text-tix-dark tracking-widest" x-text="currentCode"></p>
            </div>
        </div>

    </div>

    <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-50">
        <div class="max-w-md mx-auto grid grid-cols-3 h-16">
            <a href="{{ route('user.home') }}" class="flex flex-col items-center justify-center text-gray-400 hover:text-tix-dark transition">
                <i class="fas fa-home text-xl mb-1"></i>
                <span class="text-[10px] font-medium tracking-wide">Beranda</span>
            </a>
            
            <a href="{{ route('tickets.index') }}" class="flex flex-col items-center justify-center text-tix-dark transition">
                <i class="fas fa-ticket-alt text-xl mb-1"></i>
                <span class="text-[10px] font-bold tracking-wide">Tiket Saya</span>
            </a>
            
            <a href="#" class="flex flex-col items-center justify-center text-gray-400 hover:text-tix-dark transition">
                <i class="fas fa-user text-xl mb-1"></i>
                <span class="text-[10px] font-medium tracking-wide">Akun</span>
            </a>
        </div>
    </nav>

</body>
</html>