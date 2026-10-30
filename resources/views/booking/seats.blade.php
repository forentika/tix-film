<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kursi - TIX ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Josefin Sans', sans-serif; background-color: #F8F9FA; }
        .bg-tix-dark { background-color: #1A2C50; }
        .text-tix-dark { color: #1A2C50; }
        
        /* Efek Layar Bioskop (Melengkung & Bersinar) */
        .screen-shadow {
            height: 8px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 15px 20px rgba(255, 255, 255, 0.8);
            margin-bottom: 30px;
            opacity: 0.8;
        }
    </style>
</head>
<body class="pb-32"> <header class="bg-white sticky top-0 z-50 shadow-sm">
        <div class="max-w-md mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() }}" class="text-tix-dark text-xl">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <div>
                    <h1 class="font-bold text-lg text-tix-dark leading-none">{{ $showtime->movie->title }}</h1>
                    <p class="text-xs text-gray-500 mt-1">{{ $showtime->studio->cinema->name }} | {{ $showtime->start_time->format('D, d M Y • H:i') }}</p>
                </div>
            </div>
        </div>
    </header>

    <div x-data="seatBooking({{ json_encode($bookedSeats) }}, {{ $showtime->price }})" class="max-w-md mx-auto min-h-screen bg-[#1A2C50]">
        
        <div class="pt-10 px-4 mb-4 text-center">
            <div class="w-full h-1 bg-gray-400 rounded-full mb-1"></div>
            <div class="screen-shadow w-full"></div>
            <p class="text-gray-400 text-[10px] uppercase tracking-widest mt-4">Layar Bioskop</p>
        </div>

        <div class="px-4 pb-10 flex justify-center overflow-x-auto">
            <div class="flex flex-col gap-2">
                @foreach(range('A', 'H') as $row)
                <div class="flex gap-2 items-center">
                    <span class="text-gray-400 text-xs w-4 font-bold">{{ $row }}</span>
                    
                    <div class="flex gap-1.5">
                        @foreach(range(1, 4) as $col)
                            @php $seatNum = $row . $col; @endphp
                            <button 
                                @click="toggleSeat('{{ $seatNum }}')"
                                :class="getSeatClass('{{ $seatNum }}')"
                                :disabled="isBooked('{{ $seatNum }}')"
                                class="w-8 h-8 rounded-t-lg text-[10px] font-bold transition-all duration-200 flex items-center justify-center shadow-sm">
                                {{-- $col --}} 
                            </button>
                        @endforeach
                    </div>

                    <div class="w-4"></div>

                    <div class="flex gap-1.5">
                        @foreach(range(5, 8) as $col)
                            @php $seatNum = $row . $col; @endphp
                            <button 
                                @click="toggleSeat('{{ $seatNum }}')"
                                :class="getSeatClass('{{ $seatNum }}')"
                                :disabled="isBooked('{{ $seatNum }}')"
                                class="w-8 h-8 rounded-t-lg text-[10px] font-bold transition-all duration-200 flex items-center justify-center shadow-sm">
                            </button>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-center gap-6 pb-6 border-t border-gray-700/50 pt-4 mx-4">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-white rounded-sm border border-gray-400"></div>
                <span class="text-gray-300 text-xs">Available</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-gray-600 rounded-sm"></div>
                <span class="text-gray-300 text-xs">Sold</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-[#FFBE00] rounded-sm"></div>
                <span class="text-gray-300 text-xs">Selected</span>
            </div>
        </div>

        <div class="fixed bottom-0 w-full max-w-md bg-white rounded-t-2xl p-5 z-50 shadow-[0_-5px_20px_rgba(0,0,0,0.1)]">
            
            <div x-show="selectedSeats.length === 0" class="text-center text-gray-500 text-sm font-bold">
                Silakan pilih kursi terlebih dahulu
            </div>

            <div x-show="selectedSeats.length > 0">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="text-xs text-gray-500">Total Harga</p>
                        <h3 class="text-xl font-bold text-tix-dark" x-text="'Rp ' + (totalPrice).toLocaleString('id-ID')"></h3>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Kursi Terpilih</p>
                        <p class="font-bold text-tix-dark text-sm truncate max-w-[150px]" x-text="selectedSeats.join(', ')"></p>
                    </div>
                </div>

                <form action="{{ route('booking.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                    <input type="hidden" name="seats" :value="selectedSeats.join(',')">
                    
                    <button type="submit" class="w-full bg-tix-dark text-white font-bold py-3 rounded-xl shadow-lg hover:bg-[#0f1d38] transition flex justify-between px-6 items-center">
                        <span>Ringkasan Order</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>

        </div>

    </div>

    <script>
        function seatBooking(bookedSeats, pricePerSeat) {
            return {
                booked: bookedSeats, // Array kursi yg sudah laku ['A1', 'A2']
                selectedSeats: [],   // Array kursi yg dipilih user saat ini
                price: pricePerSeat,

                // Cek apakah kursi sudah dibooking orang lain
                isBooked(seatNum) {
                    return this.booked.includes(seatNum);
                },

                // Fungsi Klik Kursi
                toggleSeat(seatNum) {
                    if (this.isBooked(seatNum)) return;

                    if (this.selectedSeats.includes(seatNum)) {
                        // Kalau sudah dipilih, hapus dari array (Unselect)
                        this.selectedSeats = this.selectedSeats.filter(s => s !== seatNum);
                    } else {
                        // Kalau belum, masukkan ke array (Select)
                        // Maksimal 6 kursi (opsional rule)
                        if (this.selectedSeats.length >= 6) {
                            alert("Maksimal 6 kursi per transaksi!");
                            return;
                        }
                        this.selectedSeats.push(seatNum);
                    }
                },

                // Menentukan Warna Kursi
                getSeatClass(seatNum) {
                    if (this.isBooked(seatNum)) {
                        return 'bg-gray-600 cursor-not-allowed border-none'; // Sold
                    }
                    if (this.selectedSeats.includes(seatNum)) {
                        return 'bg-[#FFBE00] text-tix-dark border-[#FFBE00] ring-2 ring-[#FFBE00] ring-offset-2 ring-offset-[#1A2C50]'; // Selected
                    }
                    return 'bg-white border border-gray-300 hover:bg-gray-200'; // Available
                },

                // Menghitung Total Harga (Getter Alpine)
                get totalPrice() {
                    return this.selectedSeats.length * this.price;
                }
            }
        }
    </script>

</body>
</html>