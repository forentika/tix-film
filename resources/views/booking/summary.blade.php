<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary - TIX ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Josefin Sans', sans-serif; background-color: #F8F9FA; }
        .bg-tix-dark { background-color: #1A2C50; }
        .text-tix-dark { color: #1A2C50; }
    </style>
</head>
<body class="pb-24">

    <header class="bg-white sticky top-0 z-50 shadow-sm">
        <div class="max-w-md mx-auto px-4 h-16 flex items-center gap-4">
            <a href="{{ url()->previous() }}" class="text-tix-dark text-xl"><i class="fas fa-chevron-left"></i></a>
            <h1 class="font-bold text-lg text-tix-dark">Order Summary</h1>
        </div>
    </header>

    <div class="max-w-md mx-auto bg-white min-h-screen">
        
        <div class="bg-red-100 text-red-600 text-center py-3 text-sm font-bold">
            Finish your transaction in 15:00
        </div>

        <div class="p-5">
            <div class="flex gap-4 mb-6 border-b border-gray-100 pb-6">
                <img src="{{ asset('storage/' . $transaction->showtime->movie->poster) }}" class="w-24 h-36 object-cover rounded-lg shadow-md">
                <div>
                    <h2 class="text-lg font-bold text-tix-dark leading-tight">{{ $transaction->showtime->movie->title }}</h2>
                    <div class="flex items-center gap-1 my-2">
                         <span class="bg-gray-100 text-gray-500 text-[10px] px-2 py-1 rounded font-bold">{{ $transaction->showtime->movie->age_rating }}</span>
                    </div>
                    <p class="font-bold text-tix-dark text-sm">{{ $transaction->showtime->studio->cinema->name }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $transaction->showtime->start_time->format('l, d M Y, H:i') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Studio: {{ $transaction->showtime->studio->name }}
                    </p>
                </div>
            </div>

            <h3 class="font-bold text-tix-dark mb-4">Transaction Details</h3>
            @php
                $qty = count($transaction->seats);
                $pricePerTicket = $transaction->showtime->price;
                $adminFeePerTicket = 4000;
            @endphp
            <div class="space-y-3 text-sm mb-6 border-b border-gray-100 pb-6">
                <div class="flex justify-between font-bold text-gray-700">
                    <span>{{ $qty }} TICKETS</span>
                    <span>Seats: {{ implode(', ', $transaction->seats) }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>REGULAR SEATS</span>
                    <span>Rp{{ number_format($pricePerTicket, 0,',','.') }} x {{ $qty }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>CONVENIENCE FEE</span>
                    <span>Rp{{ number_format($adminFeePerTicket, 0,',','.') }} x {{ $qty }}</span>
                </div>
            </div>

            <div class="text-[11px] text-red-500 space-y-1 mb-10">
                <p>* Purchased tickets cannot be changed / cancelled.</p>
                <p>* Children (2 years old/above) are required to purchase ticket.</p>
            </div>
        </div>

        <div class="fixed bottom-0 w-full max-w-md bg-white border-t p-4 z-50 shadow-[0_-5px_20px_rgba(0,0,0,0.1)]">
            <div class="flex justify-between items-center mb-4 px-2">
                <span class="text-sm font-bold text-gray-600">ACTUAL PAY</span>
                <span class="text-xl font-bold text-tix-dark">Rp{{ number_format($transaction->total_price, 0,',','.') }}</span>
            </div>
            
            <form action="{{ route('payment.process') }}" method="POST">
                @csrf
                <input type="hidden" name="booking_code" value="{{ $transaction->booking_code }}">
                <button type="submit" class="w-full bg-tix-dark text-white font-bold py-3 rounded-xl shadow-lg hover:bg-[#0f1d38] transition text-center">
                    SELECT PAYMENT
                </button>
            </form>
        </div>

    </div>
</body>
</html>