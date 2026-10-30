@extends('layouts.admin')

@section('title', 'Manajemen Film')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800 text-lg">Daftar Film</h3>
            <p class="text-sm text-gray-500">Kelola film yang akan tayang di bioskop.</p>
        </div>
        <button onclick="openModal('createModal')" class="bg-[#1A2C50] hover:bg-[#0f1d38] text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition">
            <i class="fas fa-plus"></i> Tambah Film
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Poster</th>
                    <th class="px-6 py-3">Info Film</th>
                    <th class="px-6 py-3">Durasi & Rating</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($movies as $movie)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="Poster" class="w-16 h-24 object-cover rounded shadow-sm">
                    </td>
                    <td class="px-6 py-4">
                        <h4 class="font-bold text-gray-800 text-base">{{ $movie->title }}</h4>
                        <p class="text-gray-500 text-xs mt-1">{{ $movie->genre }}</p>
                        <p class="text-gray-500 text-xs">Dir: {{ $movie->director }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            <span class="flex items-center gap-1 text-gray-600">
                                <i class="far fa-clock"></i> {{ floor($movie->duration_minutes / 60) }}j {{ $movie->duration_minutes % 60 }}m
                            </span>
                            <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-0.5 rounded w-fit">
                                {{ $movie->age_rating }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($movie->status == 'now_showing')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">Sedang Tayang</span>
                        @elseif($movie->status == 'presale')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">Pre-Sale</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">Coming Soon</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick='openEditModal(@json($movie))' class="text-blue-600 hover:bg-blue-50 p-2 rounded transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" onsubmit="return confirm('Yakin hapus film ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:bg-red-50 p-2 rounded transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Belum ada data film. Klik tombol tambah untuk memulai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="createModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal('createModal')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tambah Film Baru</h3>
                    <button onclick="closeModal('createModal')" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Judul Film</label>
                            <input type="text" name="title" class="w-full border rounded px-3 py-2 focus:ring-[#1A2C50] focus:border-[#1A2C50]" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Genre</label>
                            <input type="text" name="genre" placeholder="e.g. Drama, Action" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Durasi (Menit)</label>
                            <input type="number" name="duration_minutes" placeholder="e.g. 120" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Sutradara</label>
                            <input type="text" name="director" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Rating Umur</label>
                            <select name="age_rating" class="w-full border rounded px-3 py-2" required>
                                <option value="SU">SU (Semua Umur)</option>
                                <option value="R13+">R13+ (Remaja)</option>
                                <option value="D17+">D17+ (Dewasa)</option>
                                <option value="P13+">P13+ (Bimbingan)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status Tayang</label>
                            <select name="status" class="w-full border rounded px-3 py-2" required>
                                <option value="now_showing">Sedang Tayang</option>
                                <option value="presale">Pre-Sale</option>
                                <option value="coming_soon">Akan Datang</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Trailer URL (Opsional)</label>
                            <input type="url" name="trailer_url" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Sinopsis</label>
                            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Poster Film</label>
                            <input type="file" name="poster" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('createModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded font-medium hover:bg-gray-300 transition">Batal</button>
                        <button type="submit" class="bg-[#1A2C50] text-white px-4 py-2 rounded font-bold hover:bg-[#0f1d38] transition">Simpan Film</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal('editModal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Film</h3>
                    <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-500"><i class="fas fa-times"></i></button>
                </div>

                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Judul Film</label>
                            <input type="text" id="edit_title" name="title" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Genre</label>
                            <input type="text" id="edit_genre" name="genre" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Durasi (Menit)</label>
                            <input type="number" id="edit_duration" name="duration_minutes" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Sutradara</label>
                            <input type="text" id="edit_director" name="director" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Rating Umur</label>
                            <select id="edit_rating" name="age_rating" class="w-full border rounded px-3 py-2" required>
                                <option value="SU">SU</option>
                                <option value="R13+">R13+</option>
                                <option value="D17+">D17+</option>
                                <option value="P13+">P13+</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                            <select id="edit_status" name="status" class="w-full border rounded px-3 py-2" required>
                                <option value="now_showing">Sedang Tayang</option>
                                <option value="presale">Pre-Sale</option>
                                <option value="coming_soon">Akan Datang</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Trailer URL</label>
                            <input type="url" id="edit_trailer" name="trailer_url" class="w-full border rounded px-3 py-2">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Sinopsis</label>
                            <textarea id="edit_desc" name="description" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Poster (Biarkan kosong jika tetap)</label>
                            <input type="file" name="poster" class="w-full text-sm text-gray-500">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('editModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded font-medium">Batal</button>
                        <button type="submit" class="bg-[#1A2C50] text-white px-4 py-2 rounded font-bold hover:bg-[#0f1d38]">Update Film</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong class="font-bold">Ada yang salah!</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Fungsi mengisi data ke Modal Edit
    function openEditModal(movie) {
        // Set Action URL Form
        let form = document.getElementById('editForm');
        form.action = '/movies/' + movie.id;

        // Isi Inputan
        document.getElementById('edit_title').value = movie.title;
        document.getElementById('edit_genre').value = movie.genre;
        document.getElementById('edit_duration').value = movie.duration_minutes;
        document.getElementById('edit_director').value = movie.director;
        document.getElementById('edit_rating').value = movie.age_rating;
        document.getElementById('edit_status').value = movie.status;
        document.getElementById('edit_trailer').value = movie.trailer_url;
        document.getElementById('edit_desc').value = movie.description;

        // Buka Modal
        openModal('editModal');
    }
</script>

@endsection