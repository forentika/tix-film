@extends('layouts.admin')

@section('title', 'Spotlight & Promo')

@section('content')

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800 text-lg">Banner Promo</h3>
            <p class="text-sm text-gray-500">Kelola banner slide di halaman utama.</p>
        </div>
        <button onclick="openModal('createModal')" class="bg-[#1A2C50] hover:bg-[#0f1d38] text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition">
            <i class="fas fa-plus"></i> Tambah Promo
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Banner Preview</th>
                    <th class="px-6 py-3">Info Promo</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($spotlights as $promo)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 w-48">
                        <img src="{{ asset('storage/' . $promo->banner) }}" alt="Banner" class="w-40 h-20 object-cover rounded-md shadow-sm">
                    </td>
                    <td class="px-6 py-4">
                        <h4 class="font-bold text-gray-800 text-base">{{ $promo->title }}</h4>
                        <p class="text-gray-500 text-xs mt-1 truncate max-w-xs">{{ $promo->description ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($promo->is_active)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-600">Non-Aktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick='openEditModal(@json($promo))' class="text-blue-600 hover:bg-blue-50 p-2 rounded transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('spotlights.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('Hapus promo ini?');">
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
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        Belum ada promo aktif.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="createModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal('createModal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Promo Baru</h3>
                    <button onclick="closeModal('createModal')" class="text-gray-400 hover:text-gray-500"><i class="fas fa-times"></i></button>
                </div>
                
                <form action="{{ route('spotlights.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Judul Promo</label>
                            <input type="text" name="title" class="w-full border rounded px-3 py-2 focus:ring-[#1A2C50] focus:border-[#1A2C50]" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan (Opsional)</label>
                            <textarea name="description" rows="2" class="w-full border rounded px-3 py-2"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Upload Banner</label>
                            <input type="file" name="banner" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                            <p class="text-xs text-gray-500 mt-1">Disarankan rasio landscape (16:9)</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                            <select name="is_active" class="w-full border rounded px-3 py-2">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('createModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-[#1A2C50] text-white px-4 py-2 rounded font-bold hover:bg-[#0f1d38]">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal('editModal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Promo</h3>
                    <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-500"><i class="fas fa-times"></i></button>
                </div>

                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Judul Promo</label>
                            <input type="text" id="edit_title" name="title" class="w-full border rounded px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Keterangan</label>
                            <textarea id="edit_description" name="description" rows="2" class="w-full border rounded px-3 py-2"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Banner (Opsional)</label>
                            <input type="file" name="banner" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                            <select id="edit_is_active" name="is_active" class="w-full border rounded px-3 py-2">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('editModal')" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-[#1A2C50] text-white px-4 py-2 rounded font-bold hover:bg-[#0f1d38]">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    function openEditModal(promo) {
        let form = document.getElementById('editForm');
        form.action = '/spotlights/' + promo.id;

        document.getElementById('edit_title').value = promo.title;
        document.getElementById('edit_description').value = promo.description;
        document.getElementById('edit_is_active').value = promo.is_active ? 1 : 0;
        
        openModal('editModal');
    }
</script>

@endsection