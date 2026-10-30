<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminTransactionController extends Controller
{
    public function index()
    {
        // Ambil data transaksi dengan relasi user, movie, dan studio
        // Urutkan dari yang terbaru
        $transactions = Transaction::with(['user', 'showtime.movie', 'showtime.studio.cinema'])
            ->latest()
            ->get();

        return view('admin.transactions.index', compact('transactions'));
    }
}