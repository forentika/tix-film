<?php

namespace App\Http\Controllers;

use App\Models\Spotlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpotlightController extends Controller
{
    public function index()
    {
        $spotlights = Spotlight::latest()->get();
        return view('admin.spotlights.index', compact('spotlights'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('banners', 'public');
        }

        Spotlight::create($validated);

        return redirect()->back()->with('success', 'Promo berhasil ditambahkan!');
    }

    public function update(Request $request, Spotlight $spotlight)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('banner')) {
            // Hapus banner lama jika ada
            if ($spotlight->banner) {
                Storage::disk('public')->delete($spotlight->banner);
            }
            $validated['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $spotlight->update($validated);

        return redirect()->back()->with('success', 'Promo berhasil diperbarui!');
    }

    public function destroy(Spotlight $spotlight)
    {
        if ($spotlight->banner) {
            Storage::disk('public')->delete($spotlight->banner);
        }
        $spotlight->delete();

        return redirect()->back()->with('success', 'Promo berhasil dihapus!');
    }
}