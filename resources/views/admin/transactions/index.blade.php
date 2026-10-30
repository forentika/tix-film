@extends('layouts.admin')

@section('title', 'Riwayat Pemesanan')

@section('content')

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800 text-lg">Semua Transaksi</h3>
            <p class="text-sm text-gray-500">Pantau status tiket dan pendapatan bioskop.</p>
        </div>
        <button class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-200 transition">
            <i class="fas fa-download mr-2"></i> Export Data
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Kode Booking</th>
                    <th class="px-6 py-3">User</th>
                    <th class="px-6 py-3">Detail Film</th>
                    <th class="px-6 py-3">Jadwal Tayang</th>
                    <th class="px-6 py-3">Status Tiket</th> <th class="px-6 py-3">Total Bayar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="font-mono font-bold text-[#1A2C50]">{{ $trx->booking_code }}</span>
                        <p class="text-xs text-gray-400">{{ $trx->created_at->format('d/m/Y H:i') }}</p>
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                {{ substr($trx->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-700 text-xs">{{ $trx->user->name }}</p>
                                <p class="text-[10px] text-gray-500">{{ $trx->user->email }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800">{{ $trx->showtime->movie->title }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $trx->showtime->studio->cinema->name }} - {{ $trx->showtime->studio->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            Kursi: <span class="font-bold text-tix-dark">{{ implode(', ', $trx->seats) }}</span>
                        </p>
                    </td>

                    <td class="px-6 py-4">
                        <span class="block font-bold text-gray-700">{{ $trx->showtime->start_time->format('d M Y') }}</span>
                        <span class="block text-xs text-gray-500">{{ $trx->showtime->start_time->format('H:i') }} WIB</span>
                    </td>

                    <td class="px-6 py-4">
                        @php
                            $now = \Carbon\Carbon::now();
                            $showTime = \Carbon\Carbon::parse($trx->showtime->start_time);
                        @endphp

                        @if($trx->status == 'success')
                            @if($showTime < $now)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-200 text-gray-500 border border-gray-300">
                                    <i class="fas fa-check-circle mr-1"></i> SUDAH DITONTON
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                    <i class="fas fa-ticket-alt mr-1"></i> AKTIF (BOOKED)
                                </span>
                            @endif
                        @elseif($trx->status == 'pending')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                <i class="fas fa-clock mr-1"></i> MENUNGGU BAYAR
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                <i class="fas fa-times-circle mr-1"></i> BATAL/GAGAL
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 font-bold text-tix-dark">
                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                        Belum ada transaksi pemesanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection