<x-app-layout> 
    <x-slot name="header"> 
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight"> 
            {{ __('Dashboard Staff Gudang') }} 
        </h2> 
    </x-slot>

    <div class="py-6">
        {{-- Welcome Message --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 dark:bg-gradient-to-r dark:from-indigo-700 dark:to-purple-700 rounded-xl p-6 text-white dark:text-gray-200 transform hover:scale-[1.02] transition-all duration-300 shadow-lg hover:shadow-2xl">
                <h3 class="text-xl font-semibold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-indigo-100 dark:text-gray-300">Kelola transaksi stok dengan mudah dan efisien</p>
                <div class="mt-3 flex items-center text-indigo-100 dark:text-gray-300">
                    <span class="text-sm">{{ now()->format('l, d F Y') }}</span>
                    <span class="mx-2 animate-pulse">•</span>
                    <span class="text-sm" id="current-time"></span>
                </div>
            </div>
        </div>

        {{-- Stats Cards Utama --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- Pending Masuk --}}
                <div class="group bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-orange-500 dark:border-orange-600 hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-4xl text-orange-500 dark:text-orange-400 group-hover:scale-110 transition-transform duration-300">📋</div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors">Pending Masuk</h3>
                            <p class="text-3xl font-bold text-orange-600 dark:text-orange-500 group-hover:text-orange-700 dark:group-hover:text-orange-400 transition-colors">{{ $pendingIn ?? 0 }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 transition-colors">Menunggu approval</p>
                        </div>
                    </div>
                </div>

                {{-- Pending Keluar --}}
                <div class="group bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-cyan-500 dark:border-cyan-600 hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-4xl text-cyan-500 dark:text-cyan-400 group-hover:scale-110 transition-transform duration-300">📤</div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors">Pending Keluar</h3>
                            <p class="text-3xl font-bold text-cyan-600 dark:text-cyan-500 group-hover:text-cyan-700 dark:group-hover:text-cyan-400 transition-colors">{{ $pendingOut ?? 0 }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 transition-colors">Menunggu approval</p>
                        </div>
                    </div>
                </div>

                {{-- Transaksi Saya --}}
                <div class="group bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-l-4 border-green-500 dark:border-green-600 hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="text-4xl text-green-500 dark:text-green-400 group-hover:scale-110 transition-transform duration-300">✅</div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors">Transaksi Saya</h3>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-500 group-hover:text-green-700 dark:group-hover:text-green-400 transition-colors">{{ $myTransactionsToday ?? 0 }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 transition-colors">Hari ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gambar Gudang --}}
        <div class="max-w-6xl mx-auto px-4 mb-8">
            <div class="relative rounded-xl overflow-hidden shadow-lg border border-gray-300 dark:border-gray-700 group">
                <img src="{{ asset('images/staff gudang.jpg') }}" 
                     onerror="this.src='https://via.placeholder.com/1200x400/7C3AED/FFFFFF?text=Staff+Gudang'; this.alt='Gudang'"
                     alt="Gudang" 
                     class="w-full h-56 object-cover object-center transition-all duration-700 group-hover:scale-110 group-hover:brightness-110">
                
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/40 to-purple-600/40 dark:from-indigo-700/40 dark:to-purple-700/40 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                
                <div class="absolute bottom-6 left-6 text-white dark:text-gray-200 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                    <h3 class="text-xl font-bold drop-shadow-lg mb-1">Staff Gudang Professional</h3>
                    <p class="text-sm drop-shadow-md text-indigo-100 dark:text-gray-300">Mengelola inventory dengan ketelitian tinggi</p>
                </div>
                
                <div class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500 dark:from-indigo-600 dark:to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700"></div>
            </div>
        </div>

        {{-- Menu Box --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                    <span class="text-2xl mr-2 animate-bounce">🚀</span>
                    Menu Operasional
                </h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Pilih operasi yang ingin Anda lakukan</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">

                {{-- Barang Masuk --}}
                <a href="{{ route('stock.in') }}"
                   class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-2xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-4 overflow-hidden">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 dark:from-green-900/50 dark:via-emerald-900/50 dark:to-teal-900/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-400 via-emerald-500 to-teal-500 dark:from-green-600 dark:via-emerald-600 dark:to-teal-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700"></div>
                    
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="relative mb-6">
                            <div class="text-green-600 dark:text-green-400 text-5xl group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">
                                ＋
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 group-hover:text-green-600 dark:group-hover:text-green-400 transition-all duration-300 mb-2">Barang Masuk</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300 mb-4">Konfirmasi penerimaan barang</p>
                        
                        <div class="w-0 group-hover:w-16 h-1 bg-green-500 dark:bg-green-600 rounded-full transition-all duration-700"></div>
                    </div>
                </a>

                {{-- Barang Keluar --}}
                <a href="{{ route('stock.out') }}"
                   class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-2xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-4 overflow-hidden">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-pink-50 to-rose-50 dark:from-red-900/50 dark:via-pink-900/50 dark:to-rose-900/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-400 via-pink-500 to-rose-500 dark:from-red-600 dark:via-pink-600 dark:to-rose-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700"></div>
                    
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="relative mb-6">
                            <div class="text-red-600 dark:text-red-400 text-5xl group-hover:scale-125 group-hover:-rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">
                                －
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 group-hover:text-red-600 dark:group-hover:text-red-400 transition-all duration-300 mb-2">Barang Keluar</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300 mb-4">Konfirmasi pengeluaran barang</p>
                        
                        <div class="w-0 group-hover:w-16 h-1 bg-red-500 dark:bg-red-600 rounded-full transition-all duration-700"></div>
                    </div>
                </a>

                {{-- Laporan Stok (Opsional, hapus jika tidak diizinkan) --}}
                <a href="{{ route('reports.stock') }}"
                   class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-2xl p-8 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-4 overflow-hidden">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-50 via-orange-50 to-amber-50 dark:from-yellow-900/50 dark:via-orange-900/50 dark:to-amber-900/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-400 via-orange-500 to-amber-500 dark:from-yellow-600 dark:via-orange-600 dark:to-amber-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700"></div>
                    
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="relative mb-6">
                            <div class="text-yellow-600 dark:text-yellow-400 text-5xl group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">
                                📦
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-all duration-300 mb-2">Laporan Stok</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300 mb-4">Cek stok produk terkini</p>
                        
                        <div class="w-0 group-hover:w-16 h-1 bg-yellow-500 dark:bg-yellow-600 rounded-full transition-all duration-700"></div>
                    </div>
                </a>

                {{-- Produk Saya --}}
                <a href="{{ route('products.index') }}"
                    class="group relative bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-2xl py-6 px-8 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-4 overflow-hidden md:col-span-3">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-cyan-50 to-teal-50 dark:from-blue-900/50 dark:via-cyan-900/50 dark:to-teal-900/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 via-cyan-500 to-teal-500 dark:from-blue-600 dark:via-cyan-600 dark:to-teal-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="flex items-center justify-center space-x-4 mb-3">
                            <div class="relative">
                                <div class="text-blue-600 dark:text-blue-400 text-4xl group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 filter group-hover:drop-shadow-lg">
                                    📋
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all duration-300">Daftar Produk</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Kelola semua produk</p>
                            </div>
                        </div>
                        <div class="w-0 group-hover:w-16 h-1 bg-blue-500 dark:bg-blue-600 rounded-full transition-all duration-700"></div>
                    </div>
                </a>

            </div>
        </div>

        {{-- Additional Stats Section --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-12">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <span class="text-2xl mr-2">📊</span>
                    Status Kerja Hari Ini
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group text-center p-4 rounded-lg hover:bg-orange-50 dark:hover:bg-orange-900/50 transition-all duration-300">
                        <div class="text-3xl text-orange-500 dark:text-orange-400 mb-2 group-hover:scale-110 transition-transform duration-300">⏳</div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200">Tasks Pending</h4>
                        <p class="text-2xl font-bold text-orange-600 dark:text-orange-500">{{ ($pendingIn ?? 0) + ($pendingOut ?? 0) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Menunggu approval</p>
                    </div>
                    
                    <div class="group text-center p-4 rounded-lg hover:bg-green-50 dark:hover:bg-green-900/50 transition-all duration-300">
                        <div class="text-3xl text-green-500 dark:text-green-400 mb-2 group-hover:scale-110 transition-transform duration-300">✅</div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200">Tasks Selesai</h4>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-500">{{ $myTransactionsToday ?? 0 }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Hari ini</p>
                    </div>
                    
                    <div class="group text-center p-4 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-all duration-300">
                        <div class="text-3xl text-blue-500 dark:text-blue-400 mb-2 group-hover:scale-110 transition-transform duration-300">🏆</div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200">Performance</h4>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-500">
                            @php $transactions = $myTransactionsToday ?? 0; @endphp
                            {{ $transactions >= 5 ? 'Excellent' : ($transactions >= 3 ? 'Good' : 'Keep Going!') }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Level kinerja</p>
                    </div>
                </div>
                
                <div class="mt-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Target Harian</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $myTransactionsToday ?? 0 }}/10</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        @php $progress = min((($myTransactionsToday ?? 0) / 10) * 100, 100); @endphp
                        <div class="bg-gradient-to-r from-blue-400 to-purple-500 dark:from-blue-600 dark:to-purple-600 h-3 rounded-full transition-all duration-1000" 
                             style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk Clock --}}
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
    </script>
</x-app-layout>