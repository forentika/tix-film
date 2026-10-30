<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CinemaController extends Controller
{
    public function index()
    {
        $cinemas = Cinema::latest()->get();
        return view('admin.cinemas.index', compact('cinemas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string',
            'address' => 'nullable|string',
            'cinema_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cinema_image')) {
            $validated['cinema_image'] = $request->file('cinema_image')->store('cinemas', 'public');
        }

        Cinema::create($validated);
        return back()->with('success', 'Bioskop berhasil ditambahkan!');
    }

    public function update(Request $request, Cinema $cinema)
    {
        // Logika update sama seperti store, tambahkan sendiri jika perlu detail
        $validated = $request->validate([
            'name' => 'required|string',
            'city' => 'required|string',
        ]);
        $cinema->update($validated);
        return back()->with('success', 'Bioskop diupdate!');
    }

    public function destroy(Cinema $cinema)
    {
        $cinema->delete();
        return back()->with('success', 'Bioskop dihapus!');
    }
}