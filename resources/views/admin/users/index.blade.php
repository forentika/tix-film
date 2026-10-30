@extends('layouts.admin')

@section('content')
<!-- Style untuk mencegah flicker pada elemen Alpine.js -->
<style>
    [x-cloak] { display: none !important; }
</style>

<!-- Load Alpine.js FIRST (tambahkan di head layout admin atau di sini) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Script Alpine.js Component -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('userManagement', () => ({
            showModal: false,
            isEdit: false,
            formAction: '',
            form: {
                name: '',
                email: '',
                role: 'user',
                id: null
            },
            openModal(type, data = null, updateUrl = null) {
                console.log('Modal opened:', type, data); // Debug log
                this.showModal = true;
                this.isEdit = (type === 'edit');
                
                if (type === 'edit' && data) {
                    // Mode Edit
                    this.form.id = data.id;
                    this.form.name = data.name;
                    this.form.email = data.email;
                    this.form.role = data.role;
                    this.formAction = updateUrl;
                } else {
                    // Mode Tambah
                    this.form.id = null;
                    this.form.name = '';
                    this.form.email = '';
                    this.form.role = 'user';
                    this.formAction = "{{ route('users.store') }}";
                }
            },
            closeModal() {
                this.showModal = false;
                // Reset form setelah close
                this.form = {
                    name: '',
                    email: '',
                    role: 'user',
                    id: null
                };
            }
        }));
    });
</script>

<div x-data="userManagement">
    
    <!-- Header Page -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data pengguna dan hak akses aplikasi.</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Alert Error -->
    @if($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- MAIN CARD: TABEL USER -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        <!-- Toolbar -->
        <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center bg-white gap-4">
            <!-- Search -->
            <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-search text-gray-400"></i>
                </span>
                <input type="text" class="w-full py-2 pl-10 pr-4 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#1A2C50] focus:ring-1 focus:ring-[#1A2C50]" placeholder="Cari pengguna...">
            </div>

            <!-- Tombol Tambah -->
            <button @click="openModal('add')" type="button" class="bg-[#1A2C50] text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:opacity-90 transition shadow-lg flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Pengguna</span>
            </button>
        </div>

        <!-- Table Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Info Pengguna</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Role</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out group">
                        
                        <!-- Info -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=1A2C50&color=fff" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Role -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($user->role == 'admin')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Admin</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">User</span>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap text-center text-xs text-gray-500">
                            <span class="flex items-center justify-center gap-1 text-green-600 font-medium">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span> Aktif
                            </span>
                            <span class="block text-[10px] text-gray-400 mt-1">Sejak {{ $user->created_at->format('d M Y') }}</span>
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Tombol Edit (FIXED) -->
                                <button 
                                    type="button"
                                    @click="openModal('edit', { 
                                        id: {{ $user->id }}, 
                                        name: {{ Js::from($user->name) }}, 
                                        email: {{ Js::from($user->email) }}, 
                                        role: {{ Js::from($user->role) }}
                                    }, {{ Js::from(route('users.update', $user->id)) }})" 
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition" 
                                    title="Edit">
                                    <i class="fas fa-pen"></i>
                                </button>
                                
                                <!-- Tombol Delete -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                                <span class="text-sm">Belum ada data pengguna.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- MODAL POPUP (ADD & EDIT) -->
    <div x-show="showModal" 
         x-cloak 
         class="fixed inset-0 z-[99] flex items-center justify-center bg-gray-900/50 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="closeModal()">
        
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform transition-all"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <!-- Modal Header -->
            <div class="bg-[#1A2C50] px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white" x-text="isEdit ? 'Edit Pengguna' : 'Tambah Pengguna Baru'"></h3>
                <button type="button" @click="closeModal()" class="text-white/70 hover:text-white transition">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Modal Form -->
            <form :action="formAction" method="POST">
                @csrf
                <!-- Method Spoofing Dinamis -->
                <input type="hidden" name="_method" value="PUT" x-bind:disabled="!isEdit">

                <div class="p-6 space-y-5">
                    <!-- Nama Input -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-user"></i></span>
                            <input type="text" name="name" x-model="form.name" required class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1A2C50] focus:ring-1 focus:ring-[#1A2C50] transition">
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" x-model="form.email" required class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1A2C50] focus:ring-1 focus:ring-[#1A2C50] transition">
                        </div>
                    </div>

                    <!-- Role Select -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Peran (Role)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-shield-alt"></i></span>
                            <select name="role" x-model="form.role" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1A2C50] focus:ring-1 focus:ring-[#1A2C50] bg-white transition appearance-none">
                                <option value="user">User (Pengguna Biasa)</option>
                                <option value="admin">Admin (Administrator)</option>
                            </select>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400"><i class="fas fa-chevron-down text-xs"></i></span>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            Password 
                            <span x-show="isEdit" class="text-xs font-normal text-red-500 italic ml-1">*Isi hanya jika ingin mengubah</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" x-bind:required="!isEdit" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#1A2C50] focus:ring-1 focus:ring-[#1A2C50] transition" placeholder="********">
                        </div>
                        <p x-show="!isEdit" class="text-xs text-gray-400 mt-1">Minimal 8 karakter.</p>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" @click="closeModal()" class="px-5 py-2 text-gray-600 font-bold hover:bg-gray-200 rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-[#1A2C50] text-white font-bold rounded-lg hover:bg-[#142240] hover:shadow-lg transition transform hover:-translate-y-0.5">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection