<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Cinema;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function index()
    {
        // Kita butuh data Bioskop untuk dropdown di Modal Tambah Studio
        $cinemas = Cinema::all(); 
        // Ambil data studio beserta info bioskopnya (Eager Loading)
        $studios = Studio::with('cinema')->latest()->get();
        
        return view('admin.studios.index', compact('studios', 'cinemas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => 'required|string', // Contoh: Studio 1
            'type' => 'required|string', // Contoh: IMAX
            'total_seats' => 'required|integer|min:1',
        ]);

        Studio::create($validated);

        return back()->with('success', 'Studio berhasil dibuat!');
    }

    public function update(Request $request, Studio $studio)
    {
        $validated = $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => 'required|string',
            'type' => 'required|string',
            'total_seats' => 'required|integer',
        ]);

        $studio->update($validated);
        return back()->with('success', 'Studio berhasil diperbarui!');
    }

    public function destroy(Studio $studio)
    {
        $studio->delete();
        return back()->with('success', 'Studio dihapus!');
    }
}