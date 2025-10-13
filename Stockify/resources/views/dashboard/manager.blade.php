<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Manager') }}
        </h2>
    </x-slot>

    <div class="py-6">
        {{-- Welcome Message dengan Efek Animasi --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="bg-gradient-to-r from-green-500 to-blue-600 rounded-xl p-6 text-white transform hover:scale-[1.02] transition-all duration-300 shadow-lg hover:shadow-2xl">
                <h3 class="text-xl font-semibold mb-2 animate-fade-in">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-green-100 animate-fade-in-delay">Monitor dan kelola stok gudang dengan efisien</p>
                <div class="mt-3 flex items-center text-green-100">
                    <span class="text-sm">{{ now()->format('l, d F Y') }}</span>
                    <span class="mx-2 animate-pulse">•</span>
                    <span class="text-sm" id="current-time"></span>
                </div>
            </div>
        </div>

        {{-- Gambar Header dengan Fallback --}}
        <div class="max-w-6xl mx-auto px-4 mb-8">
            <div class="relative rounded-xl overflow-hidden shadow-lg border border-gray-300 group">
                <img src="{{ asset('images/man-gudang.jpg') }}" 
                     onerror="this.src='https://via.placeholder.com/1200x400/4F46E5/FFFFFF?text=Manager+Gudang'; this.alt='Dashboard Manager'"
                     alt="Dashboard Manager" 
                     class="w-full h-56 object-cover object-center transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-r from-green-600/30 to-blue-600/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute bottom-4 left-4 text-white opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                    <h3 class="text-lg font-bold drop-shadow-lg">Manager Gudang Professional</h3>
                    <p class="text-sm drop-shadow-md">Mengelola inventory dengan presisi dan efisiensi</p>
                </div>
                <div class="absolute top-4 right-4 text-white opacity-0 group-hover:opacity-100 transition-all duration-500">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-3 py-2">
                        <span class="text-xs font-semibold">Dashboard Manager</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Box Ringkasan Data dengan Efek Hover Menarik --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Box untuk "Stok Menipis" --}}
                <div class="group bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-base text-gray-500 dark:text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-500 transition-colors duration-300">Stok Menipis</h3>
                            <div class="text-2xl text-red-500 dark:text-red-400 group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">⚠️</div>
                        </div>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-500 group-hover:text-red-700 dark:group-hover:text-red-600 transition-colors duration-300">{{ $lowStockCount ?? 0 }}</p>
                        <div class="mt-3 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <div class="h-1 bg-red-200 dark:bg-red-900 rounded-full">
                                <div class="h-1 bg-red-500 dark:bg-red-600 rounded-full w-3/4 transition-all duration-1000"></div>
                            </div>
                            <p class="text-xs text-red-600 dark:text-red-500 mt-1">Perlu perhatian segera!</p>
                        </div>
                    </div>
                </div>

                {{-- Box untuk "Barang Masuk Hari Ini" --}}
                <div class="group bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-base text-gray-500 dark:text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-500 transition-colors duration-300">Barang Masuk Hari Ini</h3>
                            <div class="text-2xl text-green-500 dark:text-green-400 group-hover:scale-125 group-hover:-rotate-12 transition-all duration-300">📥</div>
                        </div>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-500 group-hover:text-green-700 dark:group-hover:text-green-600 transition-colors duration-300">{{ $transactionsInToday ?? 0 }}</p>
                        <div class="mt-3 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <div class="h-1 bg-green-200 dark:bg-green-900 rounded-full">
                                <div class="h-1 bg-green-500 dark:bg-green-600 rounded-full w-4/5 transition-all duration-1000"></div>
                            </div>
                            <p class="text-xs text-green-600 dark:text-green-500 mt-1">Produktivitas bagus!</p>
                        </div>
                    </div>
                </div>

                {{-- Box untuk "Barang Keluar Hari Ini" --}}
                <div class="group bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-cyan-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-base text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500 transition-colors duration-300">Barang Keluar Hari Ini</h3>
                            <div class="text-2xl text-blue-500 dark:text-blue-400 group-hover:scale-125 group-hover:rotate-12 transition-all duration-300">📤</div>
                        </div>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-500 group-hover:text-blue-700 dark:group-hover:text-blue-600 transition-colors duration-300">{{ $transactionsOutToday ?? 0 }}</p>
                        <div class="mt-3 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <div class="h-1 bg-blue-200 dark:bg-blue-900 rounded-full">
                                <div class="h-1 bg-blue-500 dark:bg-blue-600 rounded-full w-3/5 transition-all duration-1000"></div>
                            </div>
                            <p class="text-xs text-blue-600 dark:text-blue-500 mt-1">Distribusi lancar!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Laporan Grafik Top 5 Produk --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-8">
            <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-500 transform hover:scale-[1.01]">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                        <span class="text-2xl mr-3 animate-spin-slow">📊</span>
                        Grafik Stok Barang (Top 5 Produk)
                    </h2>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Live Data</span>
                    </div>
                </div>
                
                @if(isset($hasChartData) && $hasChartData)
                    <div class="py-6 w-full max-w-lg mx-auto">
                        <div id="top-products-chart" class="transition-all duration-500"></div>
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

        {{-- Menu Navigasi --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                    <span class="text-2xl mr-2">🚀</span>
                    Menu Navigasi
                </h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <a href="{{ route('stock-transactions.index') }}"
                   class="group bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-3 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-blue-500 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-400 to-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="text-green-600 dark:text-green-500 text-4xl mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500">🔄</div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 group-hover:text-green-600 dark:group-hover:text-green-500 transition-colors duration-300 mb-2">Transaksi Stok</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Barang masuk & keluar</p>
                        <div class="mt-3 w-0 group-hover:w-12 h-0.5 bg-green-500 transition-all duration-500"></div>
                    </div>
                </a>

                <a href="{{ route('reports.stock') }}"
                   class="group bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-3 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-400 to-orange-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="text-yellow-600 dark:text-yellow-500 text-4xl mb-4 group-hover:scale-125 group-hover:-rotate-12 transition-all duration-500">📦</div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 group-hover:text-yellow-600 dark:group-hover:text-yellow-500 transition-colors duration-300 mb-2">Laporan Stok</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Data stok produk</p>
                        <div class="mt-3 w-0 group-hover:w-12 h-0.5 bg-yellow-500 transition-all duration-500"></div>
                    </div>
                </a>

                <a href="{{ route('reports.transactions') }}"
                   class="group bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 hover:shadow-2xl transition-all duration-500 transform hover:scale-110 hover:-translate-y-3 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-pink-500 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-400 to-pink-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div class="text-purple-600 dark:text-purple-500 text-4xl mb-4 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500">📊</div>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 group-hover:text-purple-600 dark:group-hover:text-purple-500 transition-colors duration-300 mb-2">Laporan Transaksi</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Riwayat transaksi</p>
                        <div class="mt-3 w-0 group-hover:w-12 h-0.5 bg-purple-500 transition-all duration-500"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Custom CSS untuk Animasi --}}
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fade-in-delay {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
        
        .animate-fade-in-delay {
            animation: fade-in-delay 0.6s ease-out 0.2s both;
        }
        
        .animate-spin-slow {
            animation: spin 3s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>

    {{-- Script untuk Clock dan Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @if(isset($hasChartData) && $hasChartData)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);
            const chartLabels = @json($chartLabels);
            
            if (!chartData || !chartLabels || chartData.length === 0) {
                console.log('No valid chart data available');
                return;
            }
            
            const options = {
                chart: {
                    type: 'donut',
                    height: 350,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 1200
                    },
                    toolbar: {
                        show: false
                    },
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 3,
                        left: 0,
                        blur: 10,
                        opacity: 0.15
                    }
                },
                series: chartData,
                labels: chartLabels,
                colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'],
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return opts.w.config.series[opts.seriesIndex]
                    },
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        colors: ['#fff']
                    },
                    dropShadow: {
                        enabled: true
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '14px',
                    markers: {
                        width: 12,
                        height: 12,
                    },
                    itemMargin: {
                        horizontal: 8,
                        vertical: 5
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Stok',
                                    fontSize: '16px',
                                    fontWeight: 600,
                                    color: '#374151',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => {
                                            return a + b;
                                        }, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                    theme: 'dark',
                    style: {
                        fontSize: '12px'
                    }
                },
                responsive: [{
                    breakpoint: 768,
                    options: {
                        chart: {
                            height: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };
            
            try {
                const chartElement = document.getElementById("top-products-chart");
                if (chartElement) {
                    const chart = new ApexCharts(chartElement, options);
                    chart.render();
                } else {
                    console.error('Chart container not found');
                }
            } catch (error) {
                console.error('Error rendering chart:', error);
            }
        });
    </script>
    @endif

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