<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; 
class BookingController extends Controller
{
    public function selectSeats(Showtime $showtime)
    {
        // 1. Ambil semua transaksi sukses/pending pada jadwal ini
        $bookedTransactions = Transaction::where('showtime_id', $showtime->id)
            ->whereIn('status', ['success', 'pending'])
            ->get();

        $bookedSeats = $bookedTransactions->pluck('seats')->flatten()->toArray();

        return view('booking.seats', compact('showtime', 'bookedSeats'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats' => 'required|string', // "A1,A2"
        ]);

        $showtime = Showtime::with('movie', 'studio.cinema')->find($request->showtime_id);
        $seatsArray = explode(',', $request->seats);
        $totalSeats = count($seatsArray);

        // Hitung Harga
        $ticketPrice = $showtime->price * $totalSeats;
        $adminFee = 4000 * $totalSeats; // Biaya admin Rp 4.000 per tiket (sesuai screenshot)
        $totalPay = $ticketPrice + $adminFee;

        // Buat Kode Booking Unik (Misal: TIX-TANGGAL-RANDOM)
        $bookingCode = 'TIX-' . now()->format('dmY') . '-' . strtoupper(Str::random(5));

        // 1. SIMPAN TRANSAKSI (Status: PENDING)
        $transaction = Transaction::create([
            'booking_code' => $bookingCode,
            'user_id' => Auth::id(),
            'showtime_id' => $showtime->id,
            'seats' => $seatsArray, // Otomatis jadi JSON karena di model sudah di-cast
            'total_price' => $totalPay,
            'status' => 'pending',
        ]);

        // 2. Redirect ke Halaman Summary
        return redirect()->route('booking.summary', $transaction->booking_code);
    }

    public function summary($booking_code)
    {
        // Ambil data transaksi berdasarkan booking code
        $transaction = Transaction::with(['showtime.movie', 'showtime.studio.cinema', 'user'])
            ->where('booking_code', $booking_code)
            ->where('user_id', Auth::id()) // Pastikan yang buka pemiliknya
            ->firstOrFail();

        if($transaction->status == 'success') {
             return redirect()->route('user.home')->with('info', 'Transaksi ini sudah dibayar.');
        }

        return view('booking.summary', compact('transaction'));
    }
}
