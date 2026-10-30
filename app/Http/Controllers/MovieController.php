<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Showtime;
use Carbon\Carbon;  

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::latest()->get();
        return view('admin.movies.index', compact('movies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string',
            'duration_minutes' => 'required|integer',
            'director' => 'required|string',
            'age_rating' => 'required|string',
            'description' => 'required|string',
            'status' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'trailer_url' => 'nullable|url'
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Movie::create($validated);

        return redirect()->back()->with('success', 'Film berhasil ditambahkan!');
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|string',
            'duration_minutes' => 'required|integer',
            'director' => 'required|string',
            'age_rating' => 'required|string',
            'description' => 'required|string',
            'status' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'trailer_url' => 'nullable|url'
        ]);

        if ($request->hasFile('poster')) {
            // Hapus gambar lama
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $movie->update($validated);

        return redirect()->back()->with('success', 'Film berhasil diperbarui!');
    }

    public function destroy(Movie $movie)
    {
        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }
        $movie->delete();

        return redirect()->back()->with('success', 'Film berhasil dihapus!');
    }

    public function show($id, Request $request)
{
    $movie = Movie::findOrFail($id);

    // 1. Ambil Tanggal Unik yang ada jadwalnya (untuk slider tanggal)
    $dates = Showtime::where('movie_id', $id)
                ->where('start_time', '>=', now()) // Hanya jadwal masa depan
                ->selectRaw('DATE(start_time) as date')
                ->distinct()
                ->orderBy('date')
                ->get()
                ->pluck('date');

    // 2. Tentukan Tanggal Terpilih (Default: Hari ini atau tanggal pertama yg tersedia)
    $selectedDate = $request->query('date', $dates->first() ?? date('Y-m-d'));

    // 3. Ambil Jadwal pada tanggal terpilih, Grouping berdasarkan Bioskop
    $showtimes = Showtime::with(['studio.cinema'])
                ->where('movie_id', $id)
                ->whereDate('start_time', $selectedDate)
                ->orderBy('start_time')
                ->get()
                ->groupBy(function($data) {
                    return $data->studio->cinema->name; // Group by Nama Bioskop
                });

    return view('home.movie_detail', compact('movie', 'dates', 'selectedDate', 'showtimes'));
}
}