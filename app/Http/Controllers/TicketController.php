<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi SUKSES milik user
        $transactions = Transaction::with(['showtime.movie', 'showtime.studio.cinema'])
            ->where('user_id', Auth::id())
            ->where('status', 'success')
            ->orderBy('created_at', 'desc')
            ->get();

        // Pisahkan data berdasarkan waktu tayang
        $upcomingTickets = $transactions->filter(function ($trx) {
            return $trx->showtime->start_time > now();
        });

        $pastTickets = $transactions->filter(function ($trx) {
            return $trx->showtime->start_time <= now();
        });

        return view('tickets.index', compact('upcomingTickets', 'pastTickets'));
    }
}