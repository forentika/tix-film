<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATS CARDS
        $totalMovies = Movie::count();
        $newMoviesCount = Movie::where('created_at', '>=', Carbon::now()->subWeek())->count(); // Film baru minggu ini
        
        $totalCinemas = Cinema::count();
        
        // Tiket Terjual Hari Ini (Hanya yang sukses)
        $ticketsSoldToday = Transaction::whereDate('created_at', Carbon::today())
            ->where('status', 'success')
            ->get()
            ->sum(function($trx) {
                return count($trx->seats);
            });

        // Pendapatan Total (Semua waktu)
        $totalRevenue = Transaction::where('status', 'success')->sum('total_price');

        // Pendapatan Bulan Ini (untuk persentase kenaikan dummy/real)
        $revenueThisMonth = Transaction::where('status', 'success')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_price');

        // 2. CHART DATA (Pendapatan 7 Hari Terakhir)
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            
            $revenue = Transaction::whereDate('created_at', $date)
                ->where('status', 'success')
                ->sum('total_price');
            
            $chartData[] = $revenue;
        }

        // 3. RECENT TRANSACTIONS (5 Terakhir)
        $recentTransactions = Transaction::with(['user', 'showtime.movie', 'showtime.studio.cinema'])
            ->latest()
            ->take(5)
            ->get();

        // 4. TOP MOVIES (Berdasarkan jumlah transaksi sukses)
        // Query ini agak kompleks: Group by movie_id, hitung jumlahnya, sort desc
        $topMovies = Transaction::where('transactions.status', 'success')
            ->join('showtimes', 'transactions.showtime_id', '=', 'showtimes.id')
            ->join('movies', 'showtimes.movie_id', '=', 'movies.id')
            ->select('movies.title', 'movies.poster', DB::raw('count(*) as total_sold'))
            ->groupBy('movies.id', 'movies.title', 'movies.poster')
            ->orderByDesc('total_sold')
            ->take(3)
            ->get();

        return view('admin.index', compact(
            'totalMovies', 'newMoviesCount', 
            'totalCinemas', 
            'ticketsSoldToday', 
            'totalRevenue', 'revenueThisMonth',
            'chartLabels', 'chartData',
            'recentTransactions',
            'topMovies'
        ));
    }
}