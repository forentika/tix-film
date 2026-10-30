@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Total Film</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalMovies }}</h3>
                <p class="text-xs text-green-500 mt-1 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i> +{{ $newMoviesCount }} Minggu ini
                </p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-500">
                <i class="fas fa-film text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Total Bioskop</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalCinemas }}</h3>
                <p class="text-xs text-gray-400 mt-1">Cabang Terdaftar</p>
            </div>
            <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-500">
                <i class="fas fa-building text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-tix-gold flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Tiket Terjual</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $ticketsSoldToday }}</h3>
                <p class="text-xs text-green-500 mt-1 flex items-center">
                    <i class="fas fa-calendar-day mr-1"></i> Hari ini
                </p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-full flex items-center justify-center text-tix-gold">
                <i class="fas fa-ticket-alt text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">
                    Rp{{ number_format($totalRevenue / 1000000, 1, ',', '.') }}jt
                </h3>
                <p class="text-xs text-gray-500 mt-1 flex items-center">
                    Bulan ini: Rp{{ number_format($revenueThisMonth / 1000000, 1, ',', '.') }}jt
                </p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                <i class="fas fa-wallet text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <h3 class="font-bold text-gray-800 mb-4">Grafik Pendapatan (7 Hari Terakhir)</h3>
        <div class="h-64 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Transaksi Terkini</h3>
                <a href="{{ route('admin.transactions.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-3 font-semibold">ID Order</th>
                            <th class="px-6 py-3 font-semibold">Film</th>
                            <th class="px-6 py-3 font-semibold">Studio</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($recentTransactions as $trx)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800 text-xs">{{ $trx->booking_code }}</td>
                            <td class="px-6 py-4 truncate max-w-[150px]">{{ $trx->showtime->movie->title }}</td>
                            <td class="px-6 py-4 text-xs">{{ $trx->showtime->studio->cinema->name }}</td>
                            <td class="px-6 py-4">
                                @if($trx->status == 'success')
                                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Paid</span>
                                @elseif($trx->status == 'pending')
                                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">Pending</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">{{ ucfirst($trx->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-tix-dark">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada transaksi masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-4">Top 3 Film Terlaris</h3>
            <div class="space-y-4">
                @forelse($topMovies as $movie)
                <div class="flex items-center gap-3 pb-3 border-b border-gray-100 last:border-0">
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="Poster" class="w-12 h-16 object-cover rounded shadow-sm">
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-gray-800 truncate">{{ $movie->title }}</h4>
                        <p class="text-xs text-gray-500">Total Transaksi</p>
                    </div>
                    <span class="text-sm font-bold text-tix-dark">{{ $movie->total_sold }} Sales</span>
                </div>
                @empty
                <div class="text-center py-4 text-gray-400 text-xs">Belum ada data penjualan film.</div>
                @endforelse
            </div>
            
            <a href="{{ route('showtimes.index') }}" class="block w-full text-center mt-6 py-2 px-4 border border-gray-300 rounded-lg text-sm text-gray-600 font-medium hover:bg-gray-50 transition">
                Kelola Jadwal Film
            </a>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'line', // Bisa diganti 'bar'
            data: {
                labels: {!! json_encode($chartLabels) !!}, // Data tanggal dari Controller
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: {!! json_encode($chartData) !!}, // Data uang dari Controller
                    backgroundColor: 'rgba(26, 44, 80, 0.1)', // Warna TIX Dark transparan
                    borderColor: '#1A2C50', // Warna TIX Dark
                    borderWidth: 2,
                    pointBackgroundColor: '#FFBE00', // Titik warna Emas
                    tension: 0.4, // Garis melengkung halus
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection