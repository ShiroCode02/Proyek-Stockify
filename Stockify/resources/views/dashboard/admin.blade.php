<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-6">
        {{-- Welcome Message dengan Efek Animasi Dinamis --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="bg-gradient-to-r from-indigo-600 via-blue-500 to-teal-500 rounded-xl p-6 text-white transform hover:scale-[1.03] transition-all duration-300 shadow-lg hover:shadow-2xl relative overflow-hidden dark:bg-gradient-to-r dark:from-indigo-700 dark:via-blue-600 dark:to-teal-600">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/20 to-teal-500/20 animate-pulse-slow dark:from-indigo-700/20 dark:to-teal-600/20"></div>
                <div class="relative z-10">
                    <h3 class="text-xl font-semibold mb-2 animate-fade-in flex items-center">
                        <span class="text-2xl mr-2 animate-bounce">🏢</span>
                        Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}!
                    </h3>
                    <p class="text-blue-100 animate-fade-in-delay dark:text-blue-200">Kelola semua operasi gudang dengan efisien</p>
                    <div class="mt-3 flex items-center text-blue-100 dark:text-blue-200">
                        <span class="text-sm">{{ now()->format('l, d F Y') }}</span>
                        <span class="mx-2 animate-pulse">•</span>
                        <span class="text-sm" id="current-time"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gambar Header dengan Efek Parallax dan Partikel --}}
        <div class="max-w-6xl mx-auto px-4 mb-8">
            <div class="relative rounded-xl overflow-hidden shadow-lg border border-gray-300 group dark:border-gray-700">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/40 to-indigo-600/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10 dark:from-blue-700/40 dark:to-indigo-700/40"></div>
                <img src="{{ asset('images/gudang-bg.jpg') }}" alt="Dashboard Admin"
                     class="w-full h-56 object-cover object-center transition-transform duration-700 group-hover:scale-110">
                <div class="absolute bottom-4 left-4 text-white opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0 z-10">
                    <h3 class="text-lg font-bold drop-shadow-lg">Admin Gudang Professional</h3>
                    <p class="text-sm drop-shadow-md">Kelola inventory dengan kontrol penuh</p>
                </div>
                <div class="absolute top-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-all duration-500 z-10">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-3 py-2 dark:bg-gray-800/20">
                        <span class="text-xs font-semibold">Dashboard Admin</span>
                    </div>
                </div>
                <canvas id="particleCanvas" class="absolute inset-0 opacity-0 group-hover:opacity-50 transition-opacity duration-500"></canvas>
            </div>
        </div>

        {{-- Ringkasan Angka dengan Progress Bar --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Total Produk --}}
                <div class="group bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-teal-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 dark:from-blue-900/50 dark:to-teal-900/50"></div>
                    <div class="relative z-10 flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-3xl text-blue-600 dark:text-blue-400 group-hover:scale-125 group-hover:rotate-12 transition-transform duration-300">📦</div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-blue-700 dark:group-hover:text-blue-500 transition-colors">Total Produk</h3>
                            <p class="text-3xl font-bold text-blue-700 dark:text-blue-500 group-hover:text-blue-800 dark:group-hover:text-blue-600 transition-colors">{{ $totalProducts ?? 0 }}</p>
                            @if(isset($totalProducts) && $totalProducts > 0)
                                <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-blue-500 to-teal-600 dark:from-blue-600 dark:to-teal-700 h-2 rounded-full transition-all duration-1000" style="width: {{ min(($totalProducts / ($maxProducts ?? 1000)) * 100, 100) }}%"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Transaksi Masuk --}}
                <div class="group bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-100 to-emerald-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 dark:from-green-900/50 dark:to-emerald-900/50"></div>
                    <div class="relative z-10 flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-3xl text-green-600 dark:text-green-400 group-hover:scale-125 group-hover:rotate-12 transition-transform duration-300">📥</div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-green-700 dark:group-hover:text-green-500 transition-colors">Transaksi Masuk</h3>
                            <p class="text-3xl font-bold text-green-700 dark:text-green-500 group-hover:text-green-800 dark:group-hover:text-green-600 transition-colors">{{ $transIn ?? 0 }}</p>
                            @if(isset($transIn) && $transIn > 0)
                                <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-600 dark:to-emerald-700 h-2 rounded-full transition-all duration-1000" style="width: {{ min(($transIn / ($maxTransIn ?? 1000)) * 100, 100) }}%"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Transaksi Keluar --}}
                <div class="group bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-100 to-pink-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 dark:from-red-900/50 dark:to-pink-900/50"></div>
                    <div class="relative z-10 flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-3xl text-red-600 dark:text-red-400 group-hover:scale-125 group-hover:rotate-12 transition-transform duration-300">📤</div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-red-700 dark:group-hover:text-red-500 transition-colors">Transaksi Keluar</h3>
                            <p class="text-3xl font-bold text-red-700 dark:text-red-500 group-hover:text-red-800 dark:group-hover:text-red-600 transition-colors">{{ $transOut ?? 0 }}</p>
                            @if(isset($transOut) && $transOut > 0)
                                <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-red-500 to-pink-600 dark:from-red-600 dark:to-pink-700 h-2 rounded-full transition-all duration-1000" style="width: {{ min(($transOut / ($maxTransOut ?? 1000)) * 100, 100) }}%"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Total Pengguna --}}
                <div class="group bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-violet-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 dark:from-purple-900/50 dark:to-violet-900/50"></div>
                    <div class="relative z-10 flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-3xl text-purple-600 dark:text-purple-400 group-hover:scale-125 group-hover:rotate-12 transition-transform duration-300">👥</div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-purple-700 dark:group-hover:text-purple-500 transition-colors">Total Pengguna</h3>
                            <p class="text-3xl font-bold text-purple-700 dark:text-purple-500 group-hover:text-purple-800 dark:group-hover:text-purple-600 transition-colors">{{ $totalUsers ?? 0 }}</p>
                            @if(isset($totalUsers) && $totalUsers > 0)
                                <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-purple-500 to-violet-600 dark:from-purple-600 dark:to-violet-700 h-2 rounded-full transition-all duration-1000" style="width: {{ min(($totalUsers / ($maxUsers ?? 1000)) * 100, 100) }}%"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Laporan Grafik Top 5 Produk dengan Interaktivitas --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-8">
            <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-500 transform hover:scale-[1.01]">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                        <span class="text-2xl mr-3 animate-bounce">📊</span>
                        Grafik Stok Barang (Top 5 Produk)
                    </h2>
                    <div class="flex items-center space-x-4">
                        <button id="toggleChartType" class="text-sm bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition-all duration-300">Ganti ke Bar</button>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Live Data</span>
                        </div>
                    </div>
                </div>
                @if(isset($hasChartData) && $hasChartData)
                    <div class="py-6 w-full max-w-lg mx-auto">
                        <canvas id="top-products-chart" class="transition-all duration-500"></canvas>
                    </div>
                @else
                    <div class="py-12 text-center">
                        <div class="text-6xl mb-4 animate-bounce">📦</div>
                        <p class="text-gray-500 dark:text-gray-400 mb-2">Belum ada data stok untuk ditampilkan</p>
                        <p class="text-sm text-gray-400 dark:text-gray-500">Tambahkan produk untuk melihat grafik yang menarik</p>
                        <div class="mt-4">
                            <div class="inline-flex items-center space-x-2 text-gray-400 dark:text-gray-500">
                                <div class="w-2 h-2 bg-gray-300 dark:bg-gray-600 rounded-full animate-pulse"></div>
                                <div class="w-2 h-2 bg-gray-300 dark:bg-gray-600 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                                <div class="w-2 h-2 bg-gray-300 dark:bg-gray-600 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Aktivitas Pengguna Terbaru --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-8">
            <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-300">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <span class="text-2xl mr-2 animate-bounce">📜</span>
                    Aktivitas Pengguna Terbaru
                </h3>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
                            <th class="p-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-gray-700 dark:text-gray-300">Tanggal</th>
                            <th class="p-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-gray-700 dark:text-gray-300">User</th>
                            <th class="p-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-gray-700 dark:text-gray-300">Produk</th>
                            <th class="p-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-gray-700 dark:text-gray-300">Jenis</th>
                            <th class="p-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-gray-700 dark:text-gray-300">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestActivities ?? [] as $activity)
                            <tr class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-blue-900/50 dark:hover:to-indigo-900/50 transition-colors duration-200">
                                <td class="p-3 border-b border-gray-200 dark:border-gray-600">{{ $activity->created_at->format('d-m-Y H:i') }}</td>
                                <td class="p-3 border-b border-gray-200 dark:border-gray-600">{{ $activity->user->name ?? 'Unknown' }}</td>
                                <td class="p-3 border-b border-gray-200 dark:border-gray-600">{{ $activity->product->name ?? 'Unknown' }}</td>
                                <td class="p-3 border-b border-gray-200 dark:border-gray-600">
                                    <span class="flex items-center {{ $activity->type === 'in' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        <span class="mr-2">{{ $activity->type === 'in' ? '📥' : '📤' }}</span>
                                        {{ $activity->type === 'in' ? 'Masuk' : 'Keluar' }}
                                    </span>
                                </td>
                                <td class="p-3 border-b border-gray-200 dark:border-gray-600">{{ $activity->quantity }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 border-b border-gray-200 dark:border-gray-600 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada aktivitas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Menu Box dengan Efek 3D --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                    <span class="text-2xl mr-2 animate-bounce">🚀</span>
                    Menu Navigasi
                </h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <a href="{{ route('products.index') }}" class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-3 perspective-1000 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-teal-100 opacity-0 group-hover:opacity-100 transition-opacity duration-500 dark:from-blue-900/50 dark:to-teal-900/50"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-teal-600 dark:from-blue-600 dark:to-teal-700 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="text-blue-600 dark:text-blue-400 text-4xl mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">🧾</div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 group-hover:text-blue-700 dark:group-hover:text-blue-500 transition-colors duration-300 mb-2">Kelola Produk</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Tambah & kelola produk</p>
                        <div class="mt-3 w-0 group-hover:w-12 h-0.5 bg-gradient-to-r from-blue-500 to-teal-600 dark:from-blue-600 dark:to-teal-700 transition-all duration-500"></div>
                    </div>
                </a>

                <a href="{{ route('stock-transactions.index') }}" class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-3 perspective-1000 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-100 to-emerald-100 opacity-0 group-hover:opacity-100 transition-opacity duration-500 dark:from-green-900/50 dark:to-emerald-900/50"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-600 dark:to-emerald-700 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="text-green-600 dark:text-green-400 text-4xl mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">🔄</div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 group-hover:text-green-700 dark:group-hover:text-green-500 transition-colors duration-300 mb-2">Transaksi Stok</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Barang masuk & keluar</p>
                        <div class="mt-3 w-0 group-hover:w-12 h-0.5 bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-600 dark:to-emerald-700 transition-all duration-500"></div>
                    </div>
                </a>

                <a href="{{ route('reports.stock') }}" class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-3 perspective-1000 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-100 to-orange-100 opacity-0 group-hover:opacity-100 transition-opacity duration-500 dark:from-yellow-900/50 dark:to-orange-900/50"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-orange-600 dark:from-yellow-600 dark:to-orange-700 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="text-yellow-600 dark:text-yellow-400 text-4xl mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">📦</div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 group-hover:text-yellow-700 dark:group-hover:text-yellow-500 transition-colors duration-300 mb-2">Laporan Stok</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Stok produk terkini</p>
                        <div class="mt-3 w-0 group-hover:w-12 h-0.5 bg-gradient-to-r from-yellow-500 to-orange-600 dark:from-yellow-600 dark:to-orange-700 transition-all duration-500"></div>
                    </div>
                </a>

                <a href="{{ route('reports.transactions') }}" class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-3 perspective-1000 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-violet-100 opacity-0 group-hover:opacity-100 transition-opacity duration-500 dark:from-purple-900/50 dark:to-violet-900/50"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-violet-600 dark:from-purple-600 dark:to-violet-700 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="text-purple-600 dark:text-purple-400 text-4xl mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">📊</div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 group-hover:text-purple-700 dark:group-hover:text-purple-500 transition-colors duration-300 mb-2">Laporan Transaksi</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Histori transaksi barang</p>
                        <div class="mt-3 w-0 group-hover:w-12 h-0.5 bg-gradient-to-r from-purple-500 to-violet-600 dark:from-purple-600 dark:to-violet-700 transition-all duration-500"></div>
                    </div>
                </a>

                <a href="{{ route('reports.users') }}" class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-3 perspective-1000 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-100 to-pink-100 opacity-0 group-hover:opacity-100 transition-opacity duration-500 dark:from-red-900/50 dark:to-pink-900/50"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-pink-600 dark:from-red-600 dark:to-pink-700 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="text-red-600 dark:text-red-400 text-4xl mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">👥</div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 group-hover:text-red-700 dark:group-hover:text-red-500 transition-colors duration-300 mb-2">Laporan User</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Aktivitas pengguna</p>
                        <div class="mt-3 w-0 group-hover:w-12 h-0.5 bg-gradient-to-r from-red-500 to-pink-600 dark:from-red-600 dark:to-pink-700 transition-all duration-500"></div>
                    </div>
                </a>

                <a href="{{ route('categories.index') }}" class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-3 perspective-1000 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-100 to-blue-100 opacity-0 group-hover:opacity-100 transition-opacity duration-500 dark:from-indigo-900/50 dark:to-blue-900/50"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-blue-600 dark:from-indigo-600 dark:to-blue-700 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="text-indigo-600 dark:text-indigo-400 text-4xl mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">📂</div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 group-hover:text-indigo-700 dark:group-hover:text-indigo-500 transition-colors duration-300 mb-2">Kategori Produk</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Kelola kategori produk</p>
                        <div class="mt-3 w-0 group-hover:w-12 h-0.5 bg-gradient-to-r from-indigo-500 to-blue-600 dark:from-indigo-600 dark:to-blue-700 transition-all duration-500"></div>
                    </div>
                </a>

                <a href="{{ route('suppliers.index') }}" class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-3 perspective-1000 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-100 to-rose-100 opacity-0 group-hover:opacity-100 transition-opacity duration-500 dark:from-pink-900/50 dark:to-rose-900/50"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-pink-500 to-rose-600 dark:from-pink-600 dark:to-rose-700 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="text-pink-600 dark:text-pink-400 text-4xl mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">🚚</div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 group-hover:text-pink-700 dark:group-hover:text-pink-500 transition-colors duration-300 mb-2">Supplier</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Kelola data supplier</p>
                        <div class="mt-3 w-0 group-hover:w-12 h-0.5 bg-gradient-to-r from-pink-500 to-rose-600 dark:from-pink-600 dark:to-rose-700 transition-all duration-500"></div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Script untuk Clock dan Partikel --}}
        <script>
            function updateTime() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('id-ID');
                const timeElement = document.getElementById('current-time');
                if (timeElement) {
                    timeElement.textContent = timeString;
                }
            }
            updateTime();
            setInterval(updateTime, 1000);

            // Script untuk Partikel di Gambar Header
            document.addEventListener('DOMContentLoaded', function() {
                const canvas = document.getElementById('particleCanvas');
                if (canvas) {
                    const ctx = canvas.getContext('2d');
                    canvas.width = canvas.offsetWidth;
                    canvas.height = canvas.offsetHeight;
                    const particles = [];
                    for (let i = 0; i < 10; i++) {
                        particles.push({
                            x: Math.random() * canvas.width,
                            y: Math.random() * canvas.height,
                            size: Math.random() * 3 + 1,
                            speedX: Math.random() * 0.5 - 0.25,
                            speedY: Math.random() * 0.5 - 0.25
                        });
                    }
                    function animateParticles() {
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
                        particles.forEach(p => {
                            ctx.beginPath();
                            ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                            ctx.fill();
                            p.x += p.speedX;
                            p.y += p.speedY;
                            if (p.x < 0 || p.x > canvas.width) p.speedX *= -1;
                            if (p.y < 0 || p.y > canvas.height) p.speedY *= -1;
                        });
                        requestAnimationFrame(animateParticles);
                    }
                    animateParticles();
                }
            });
        </script>

        {{-- Script Chart.js untuk Grafik --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @if(isset($hasChartData) && $hasChartData)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chartData = @json($chartData ?? []);
                const chartLabels = @json($chartLabels ?? []);

                if (!chartData || !chartLabels || chartData.length === 0) {
                    console.log('No valid chart data available');
                    return;
                }

                let chartType = 'doughnut';
                const ctx = document.getElementById('top-products-chart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: chartType,
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            data: chartData,
                            backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
                            borderColor: ['#fff'],
                            borderWidth: 2,
                            hoverOffset: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 14
                                    },
                                    padding: 20
                                }
                            },
                            tooltip: {
                                enabled: true,
                                callbacks: {
                                    label: function(context) {
                                        return `${context.label}: ${context.raw} unit`;
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 1200,
                            easing: 'easeInOutQuad'
                        },
                        layout: {
                            padding: 10
                        },
                        scales: chartType === 'bar' ? {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e5e7eb'
                                }
                            }
                        } : {}
                    }
                });

                const toggleButton = document.getElementById('toggleChartType');
                if (toggleButton) {
                    toggleButton.addEventListener('click', function() {
                        chartType = chartType === 'doughnut' ? 'bar' : 'doughnut';
                        chart.config.type = chartType;
                        chart.options.scales = chartType === 'bar' ? {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e5e7eb'
                                }
                            }
                        } : {};
                        chart.update();
                        this.textContent = `Ganti ke ${chartType === 'doughnut' ? 'Bar' : 'Doughnut'}`;
                    });
                }
            });
        </script>
        @endif
    </div>
</x-app-layout>