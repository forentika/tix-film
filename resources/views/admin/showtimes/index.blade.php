@extends('layouts.admin')

@section('title', 'Atur Jadwal Tayang')

@section('content')

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4 border-l-4 border-red-500">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-4 border-l-4 border-green-500">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800 text-lg">Jadwal Film (Showtimes)</h3>
            <p class="text-sm text-gray-500">Kelola kapan dan dimana film diputar.</p>
        </div>
        <button onclick="openModal('createScheduleModal')" class="bg-[#1A2C50] text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 hover:bg-[#0f1d38] transition">
            <i class="fas fa-calendar-plus"></i> Tambah Jadwal
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Film</th>
                    <th class="px-6 py-3">Lokasi & Studio</th>
                    <th class="px-6 py-3">Tanggal & Jam</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($showtimes as $show)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($show->movie->poster)
                            <img src="{{ asset('storage/' . $show->movie->poster) }}" class="w-10 h-14 object-cover rounded shadow-sm">
                            @endif
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $show->movie->title }}</h4>
                                <span class="text-xs text-gray-500">{{ $show->movie->duration_minutes }} Menit</span>
                            </div>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-700">{{ $show->studio->cinema->name }}</p>
                        <p class="text-xs text-gray-500">{{ $show->studio->name }} ({{ $show->studio->type }})</p>
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-bold text-[#1A2C50]">
                                {{ $show->start_time->format('d M Y') }}
                            </span>
                            <span class="text-sm text-gray-600">
                                {{ $show->start_time->format('H:i') }} - {{ $show->end_time->format('H:i') }}
                            </span>
                        </div>
                    </td>

                    <td class="px-6 py-4 font-bold text-green-600">
                        Rp {{ number_format($show->price, 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('showtimes.destroy', $show->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:bg-red-50 p-2 rounded transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada jadwal tayang dibuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="createScheduleModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg w-full max-w-lg p-6 shadow-xl transform transition-all">
        <div class="flex justify-between items-center mb-5 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-800">Buat Jadwal Baru</h3>
            <button onclick="closeModal('createScheduleModal')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="{{ route('showtimes.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                
                <div>
                    <label class="block text-sm font-bold mb-1 text-gray-700">Pilih Film</label>
                    <select name="movie_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#1A2C50] focus:border-transparent outline-none" required>
                        <option value="">-- Pilih Film --</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}">{{ $movie->title }} ({{ $movie->duration_minutes }} min)</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold mb-1 text-gray-700">Pilih Studio & Bioskop</label>
                    <select name="studio_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#1A2C50] focus:border-transparent outline-none" required>
                        <option value="">-- Pilih Studio --</option>
                        @foreach($studios as $studio)
                            <option value="{{ $studio->id }}">
                                {{ $studio->cinema->name }} - {{ $studio->name }} ({{ $studio->type }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">Waktu Mulai</label>
                        <input type="datetime-local" name="start_time" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#1A2C50] outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">Harga Tiket (Rp)</label>
                        <input type="number" name="price" placeholder="50000" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#1A2C50] outline-none" required>
                    </div>
                </div>

                <div class="bg-blue-50 text-blue-800 text-xs p-3 rounded mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Jam selesai akan dihitung otomatis: <b>Waktu Mulai + Durasi Film + 15 Menit.</b>
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="closeModal('createScheduleModal')" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg font-medium hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="bg-[#1A2C50] text-white px-5 py-2.5 rounded-lg font-bold shadow hover:bg-[#0f1d38] transition">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
</script>

@endsection