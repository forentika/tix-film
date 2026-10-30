@extends('layouts.admin')

@section('title', 'Kelola Studio')

@section('content')

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800 text-lg">Daftar Studio</h3>
            <p class="text-sm text-gray-500">Atur ruangan studio untuk setiap bioskop.</p>
        </div>
        <button onclick="openModal('createStudioModal')" class="bg-[#1A2C50] text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 hover:bg-[#0f1d38] transition">
            <i class="fas fa-plus"></i> Tambah Studio
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Lokasi Bioskop</th>
                    <th class="px-6 py-3">Nama Studio</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Kapasitas</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($studios as $studio)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold text-gray-700">
                        <i class="fas fa-building text-gray-400 mr-2"></i> {{ $studio->cinema->name }}
                        <span class="text-xs text-gray-500 block ml-6">{{ $studio->cinema->city }}</span>
                    </td>
                    <td class="px-6 py-4 font-bold text-[#1A2C50]">{{ $studio->name }}</td>
                    <td class="px-6 py-4">
                        @if($studio->type == 'IMAX')
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-bold">IMAX</span>
                        @elseif($studio->type == 'Premiere')
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-bold">PREMIERE</span>
                        @else
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">REGULAR</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $studio->total_seats }} Kursi</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick='openEditModal(@json($studio))' class="text-blue-600 hover:bg-blue-50 p-2 rounded"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('studios.destroy', $studio->id) }}" method="POST" onsubmit="return confirm('Hapus studio ini?');">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:bg-red-50 p-2 rounded"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada studio. Tambahkan Bioskop dulu jika kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="createStudioModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-xl transform transition-all">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-lg font-bold">Tambah Studio Baru</h3>
            <button onclick="closeModal('createStudioModal')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="{{ route('studios.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Pilih Bioskop</label>
                    <select name="cinema_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}">{{ $cinema->name }} ({{ $cinema->city }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1">Nama Studio</label>
                    <input type="text" name="name" placeholder="Contoh: Studio 1" class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1">Tipe Studio</label>
                    <select name="type" class="w-full border rounded px-3 py-2">
                        <option value="Regular">Regular 2D</option>
                        <option value="IMAX">IMAX</option>
                        <option value="Premiere">The Premiere</option>
                        <option value="Gold">Gold Class</option>
                        <option value="4DX">4DX</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1">Total Kursi</label>
                    <input type="number" name="total_seats" placeholder="Contoh: 120" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="closeModal('createStudioModal')" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                <button type="submit" class="bg-[#1A2C50] text-white px-4 py-2 rounded font-bold">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="editStudioModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 shadow-xl">
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h3 class="text-lg font-bold">Edit Studio</h3>
            <button onclick="closeModal('editStudioModal')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Pilih Bioskop</label>
                    <select id="edit_cinema_id" name="cinema_id" class="w-full border rounded px-3 py-2" required>
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}">{{ $cinema->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Nama Studio</label>
                    <input type="text" id="edit_name" name="name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Tipe Studio</label>
                    <select id="edit_type" name="type" class="w-full border rounded px-3 py-2">
                        <option value="Regular">Regular 2D</option>
                        <option value="IMAX">IMAX</option>
                        <option value="Premiere">The Premiere</option>
                        <option value="Gold">Gold Class</option>
                        <option value="4DX">4DX</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Total Kursi</label>
                    <input type="number" id="edit_seats" name="total_seats" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="closeModal('editStudioModal')" class="bg-gray-200 px-4 py-2 rounded">Batal</button>
                <button type="submit" class="bg-[#1A2C50] text-white px-4 py-2 rounded font-bold">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    
    function openEditModal(studio) {
        let form = document.getElementById('editForm');
        form.action = '/studios/' + studio.id;
        
        document.getElementById('edit_cinema_id').value = studio.cinema_id;
        document.getElementById('edit_name').value = studio.name;
        document.getElementById('edit_type').value = studio.type;
        document.getElementById('edit_seats').value = studio.total_seats;
        
        openModal('editStudioModal');
    }
</script>

@endsection