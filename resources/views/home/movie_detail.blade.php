<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} - TIX ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Josefin Sans', sans-serif; background-color: #F8F9FA; }
        .bg-tix-dark { background-color: #1A2C50; }
        .text-tix-dark { color: #1A2C50; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="pb-24">

    <header class="bg-white sticky top-0 z-50 shadow-sm">
        <div class="max-w-md mx-auto px-4 h-16 flex items-center gap-4">
            <a href="{{ route('user.home') }}" class="text-tix-dark text-xl">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h1 class="font-bold text-lg text-tix-dark">Movie Details</h1>
        </div>
    </header>

    <div class="max-w-md mx-auto bg-white min-h-screen">
        
        <div class="p-4">
            <div class="bg-gray-50 border border-gray-100 p-3 rounded-lg flex items-center justify-between mb-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="bg-tix-dark text-white p-2 rounded w-10 h-10 flex items-center justify-center font-bold text-xs">TIX</div>
                    <div>
                        <p class="text-xs font-bold text-tix-dark">Dapatkan TIX Point!</p>
                        <p class="text-[10px] text-gray-500">Kumpulkan point untuk diskon.</p>
                    </div>
                </div>
                <button class="bg-tix-dark text-white text-[10px] px-3 py-1.5 rounded-full font-bold">INFO</button>
            </div>

            <div class="flex gap-4">
                <img src="{{ asset('storage/' . $movie->poster) }}" class="w-28 h-40 object-cover rounded-lg shadow-md">
                <div class="flex-1">
                    <h2 class="text-lg font-bold text-tix-dark leading-tight mb-2">{{ $movie->title }}</h2>
                    <div class="flex flex-wrap gap-2 mb-2">
                        <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-1 rounded font-bold">{{ $movie->age_rating }}</span>
                        <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-1 rounded font-bold">{{ $movie->genre }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mb-1">Duration: {{ floor($movie->duration_minutes / 60) }}h {{ $movie->duration_minutes % 60 }}m</p>
                    <p class="text-xs text-gray-500 mb-4">Director: {{ $movie->director }}</p>
                    @if($movie->trailer_url)
                    <a href="{{ $movie->trailer_url }}" target="_blank" class="inline-block border border-gray-300 text-tix-dark text-xs font-bold px-4 py-1.5 rounded-full hover:bg-gray-50 transition">See Trailer</a>
                    @endif
                </div>
            </div>
        </div>

        <div x-data="{ activeTab: 'schedule', selectedScheduleId: null }">
            
            <div class="flex border-b border-gray-200 mt-2 sticky top-16 bg-white z-40">
                <button @click="activeTab = 'synopsis'" class="flex-1 py-3 text-sm font-bold text-center transition relative" :class="activeTab === 'synopsis' ? 'text-tix-dark' : 'text-gray-400'">
                    SYNOPSIS
                    <div x-show="activeTab === 'synopsis'" class="absolute bottom-0 left-0 w-full h-0.5 bg-tix-dark"></div>
                </button>
                <button @click="activeTab = 'schedule'" class="flex-1 py-3 text-sm font-bold text-center transition relative" :class="activeTab === 'schedule' ? 'text-tix-dark' : 'text-gray-400'">
                    SCHEDULE
                    <div x-show="activeTab === 'schedule'" class="absolute bottom-0 left-0 w-full h-0.5 bg-tix-dark"></div>
                </button>
            </div>

            <div x-show="activeTab === 'synopsis'" class="p-6 text-sm text-gray-600 leading-relaxed min-h-[300px]">
                <p>{{ $movie->description }}</p>
            </div>

            <div x-show="activeTab === 'schedule'">
                
                <div class="bg-white py-4 border-b border-gray-100">
                    <div class="flex overflow-x-auto px-4 gap-3 scrollbar-hide">
                        @foreach($dates as $date)
                        @php $isSelected = $date == $selectedDate; $carbonDate = \Carbon\Carbon::parse($date); @endphp
                        <a href="?date={{ $date }}" class="flex flex-col items-center justify-center min-w-[70px] h-[70px] rounded border transition {{ $isSelected ? 'bg-tix-dark text-white border-tix-dark' : 'bg-white text-gray-400 border-gray-200' }}">
                            <span class="text-[10px] font-bold uppercase">{{ $carbonDate->format('D') }}</span>
                            <span class="text-lg font-bold">{{ $carbonDate->format('d') }}</span>
                            <span class="text-[10px] uppercase">{{ $carbonDate->format('M') }}</span>
                        </a>
                        @endforeach
                        @if($dates->isEmpty())
                        <div class="text-sm text-gray-400 italic w-full text-center">Tidak ada jadwal tersedia.</div>
                        @endif
                    </div>
                </div>

                <div class="bg-gray-100 min-h-[300px] pb-10">
                    <div class="bg-white p-3 shadow-sm mb-2">
                         <div class="bg-gray-100 rounded-lg flex items-center px-3 py-2">
                            <i class="fas fa-search text-gray-400 text-xs"></i>
                            <input type="text" placeholder="Search cinema" class="bg-transparent border-none focus:outline-none text-xs ml-2 w-full">
                        </div>
                    </div>

                    @forelse($showtimes as $cinemaName => $times)
                    <div class="bg-white mb-2 p-4 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-bold text-tix-dark text-sm flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-2 text-xs"></i> {{ $cinemaName }}
                            </h3>
                        </div>
                        
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($times as $time)
                                @php
                                    // LOGIKA DISABLE JIKA JAM SUDAH LEWAT
                                    $isPast = $time->start_time->isPast();
                                @endphp

                                <button 
                                    {{ $isPast ? 'disabled' : '' }}
                                    @if(!$isPast) @click="selectedScheduleId = {{ $time->id }}" @endif
                                    :class="selectedScheduleId === {{ $time->id }} 
                                        ? 'bg-tix-dark text-white border-tix-dark ring-2 ring-offset-1 ring-tix-dark' 
                                        : '{{ $isPast ? 'bg-gray-100 text-gray-300 border-gray-200 cursor-not-allowed' : 'bg-white text-gray-700 border-gray-300 hover:border-tix-dark' }}'"
                                    class="border rounded text-center py-2 transition group relative flex flex-col items-center justify-center gap-0.5">
                                    
                                    <span class="text-xs font-bold {{ $isPast ? 'line-through decoration-gray-300' : '' }}">
                                        {{ $time->start_time->format('H:i') }}
                                    </span>
                                    
                                    <span class="text-[10px]" 
                                          :class="selectedScheduleId === {{ $time->id }} ? 'text-gray-200' : '{{ $isPast ? 'text-gray-300' : 'text-gray-400' }}'">
                                        Rp{{ number_format($time->price/1000, 0) }}k
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center pt-10 text-gray-400">
                        <i class="fas fa-calendar-times text-4xl mb-2"></i>
                        <p class="text-sm">Tidak ada jadwal di tanggal ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="fixed bottom-0 w-full max-w-md bg-white border-t p-4 z-50 shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">
                
                <button x-show="!selectedScheduleId" class="w-full bg-gray-200 text-gray-400 font-bold py-3 rounded-lg text-sm cursor-not-allowed">
                    Pilih Jadwal Di Atas
                </button>

                <div x-show="selectedScheduleId" style="display: none;">
                    <a :href="'/booking/seats/' + selectedScheduleId" class="block w-full bg-tix-dark text-white font-bold py-3 rounded-lg text-sm text-center shadow-lg hover:bg-[#0f1d38] transition">
                        BELI TIKET
                    </a>
                </div>

            </div>

        </div> 
    </div>
</body>
</html>