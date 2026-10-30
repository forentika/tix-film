@extends('layouts.admin')
@section('title', 'Kelola Bioskop')
@section('content')

@if(session('success')) <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div> @endif

<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex justify-between mb-4">
        <h3 class="font-bold text-lg">Daftar Bioskop</h3>
        <button onclick="document.getElementById('addCinemaModal').classList.remove('hidden')" class="bg-tix-dark text-white px-4 py-2 rounded">Tambah Bioskop</button>
    </div>
    <table class="w-full text-left">
        <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-xs">
                <th class="px-4 py-3">Nama Bioskop</th>
                <th class="px-4 py-3">Kota</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($cinemas as $cinema)
            <tr>
                <td class="px-4 py-3 font-semibold">{{ $cinema->name }}</td>
                <td class="px-4 py-3">{{ $cinema->city }}</td>
                <td class="px-4 py-3 text-right">
                    <form action="{{ route('cinemas.destroy', $cinema->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-500" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="addCinemaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h3 class="font-bold mb-4">Tambah Bioskop</h3>
        <form action="{{ route('cinemas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3"><label>Nama Bioskop</label><input type="text" name="name" class="w-full border p-2 rounded" required placeholder="Contoh: CGV Grand Indonesia"></div>
            <div class="mb-3"><label>Kota</label><input type="text" name="city" class="w-full border p-2 rounded" required placeholder="Jakarta"></div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="document.getElementById('addCinemaModal').classList.add('hidden')" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                <button type="submit" class="bg-tix-dark text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection