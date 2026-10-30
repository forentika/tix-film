<?php

namespace App\Http\Controllers;

use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Studio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShowtimeController extends Controller
{
    public function index()
    {
        // Ambil data dengan relasi agar query ringan
        $showtimes = Showtime::with(['movie', 'studio.cinema'])->latest()->get();
        
        // Data untuk dropdown di Modal
        $movies = Movie::where('status', '!=', 'coming_soon')->get(); // Hanya film yang tayang/presale
        $studios = Studio::with('cinema')->get();

        return view('admin.showtimes.index', compact('showtimes', 'movies', 'studios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'studio_id' => 'required|exists:studios,id',
            'start_time' => 'required|date|after:now', // Jadwal harus masa depan
            'price' => 'required|integer|min:10000',
        ]);

        // 1. Ambil Data Film untuk tahu durasinya
        $movie = Movie::find($request->movie_id);
        
        // 2. Hitung Jam Selesai
        // Tambahkan durasi film + 15 menit untuk bersih-bersih studio (optional logic)
        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addMinutes($movie->duration_minutes + 15);

        // 3. (Opsional) Cek Bentrok Jadwal di Studio yang sama
        // "Apakah ada jadwal lain di studio ini yang waktunya bertabrakan?"
        $bentrok = Showtime::where('studio_id', $request->studio_id)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime]);
            })->exists();

        if ($bentrok) {
            return back()->withErrors(['start_time' => 'Jadwal bentrok dengan film lain di studio ini!']);
        }

        Showtime::create([
            'movie_id' => $request->movie_id,
            'studio_id' => $request->studio_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $request->price,
        ]);

        return back()->with('success', 'Jadwal tayang berhasil dibuat!');
    }

    public function destroy(Showtime $showtime)
    {
        $showtime->delete();
        return back()->with('success', 'Jadwal dihapus!');
    }
}