<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Transaksi Stok') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notifikasi -->
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 p-4 mb-6 rounded-lg shadow-lg flex items-center animate-fade-in">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 p-4 mb-6 rounded-lg shadow-lg flex items-center animate-fade-in">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                </div>
            @endif
            
            <!-- Navigasi Laporan -->
            <nav class="bg-gray-100 dark:bg-gray-800 p-2 rounded-md mb-4">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('reports.stock') }}" class="{{ request()->routeIs('reports.stock') ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">Stok</a>
                    </li>
                    <li>
                        <a href="{{ route('reports.transactions') }}" class="{{ request()->routeIs('reports.transactions') ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">Transaksi</a>
                    </li>
                    @if(Auth::user()->role === 'admin')
                        <li>
                            <a href="{{ route('reports.users') }}" class="{{ request()->routeIs('reports.users') ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">Aktivitas Pengguna</a>
                        </li>
                    @endif
                </ul>
            </nav>

            <!-- Filter tanggal -->
            <div class="bg-white dark:bg-gray-800 p-4 mb-4 rounded-lg shadow-md">
                <form method="GET" action="{{ route('reports.transactions') }}" class="flex space-x-4 items-end">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                        <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="border rounded px-2 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                        <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="border rounded px-2 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Total -->
            <div class="bg-white dark:bg-gray-800 p-4 mb-4 rounded-lg shadow-md">
                <p class="text-gray-700 dark:text-gray-300">Total Barang Masuk: {{ $transactions->where('type', 'in')->sum('quantity') }}</p>
                <p class="text-gray-700 dark:text-gray-300">Total Barang Keluar: {{ $transactions->where('type', 'out')->sum('quantity') }}</p>
            </div>

            <!-- Tabel transaksi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                @if(!in_array('product', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                    <th class="border px-4 py-2 text-gray-700 dark:text-gray-300">Produk</th>
                                @endif
                                @if(!in_array('type', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                    <th class="border px-4 py-2 text-gray-700 dark:text-gray-300">Jenis</th>
                                @endif
                                @if(!in_array('quantity', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                    <th class="border px-4 py-2 text-gray-700 dark:text-gray-300">Jumlah</th>
                                @endif
                                @if(!in_array('date', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                    <th class="border px-4 py-2 text-gray-700 dark:text-gray-300">Tanggal</th>
                                @endif
                                @if(!in_array('status', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                    <th class="border px-4 py-2 text-gray-700 dark:text-gray-300">Status</th>
                                @endif
                                @if(!in_array('notes', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                    <th class="border px-4 py-2 text-gray-700 dark:text-gray-300">Catatan</th>
                                @endif
                                @if(!in_array('user', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                    <th class="border px-4 py-2 text-gray-700 dark:text-gray-300">User</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    @if(!in_array('product', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                        <td class="border px-4 py-2 text-gray-700 dark:text-gray-300">{{ $transaction->product->name }}</td>
                                    @endif
                                    @if(!in_array('type', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                        <td class="border px-4 py-2 text-gray-700 dark:text-gray-300">
                                            {{ $transaction->type == 'in' ? 'Masuk' : 'Keluar' }}
                                        </td>
                                    @endif
                                    @if(!in_array('quantity', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                        <td class="border px-4 py-2 text-gray-700 dark:text-gray-300">{{ $transaction->quantity }}</td>
                                    @endif
                                    @if(!in_array('date', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                        <td class="border px-4 py-2 text-gray-700 dark:text-gray-300">{{ $transaction->date }}</td>
                                    @endif
                                    @if(!in_array('status', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                        <td class="border px-4 py-2 text-gray-700 dark:text-gray-300">{{ ucfirst($transaction->status) }}</td>
                                    @endif
                                    @if(!in_array('notes', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                        <td class="border px-4 py-2 text-gray-700 dark:text-gray-300">{{ $transaction->notes ?? '-' }}</td>
                                    @endif
                                    @if(!in_array('user', $default_hidden_columns_transactions ?? []) || !in_array(Auth::user()->role, $default_hidden_for_transactions ?? []) || Auth::user()->role === 'admin')
                                        <td class="border px-4 py-2 text-gray-700 dark:text-gray-300">{{ $transaction->user->name }}</td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-gray-500 dark:text-gray-300">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 🔽 Tombol Ekspor Pindah ke Bawah Tabel -->
            <div class="flex gap-2 justify-end mt-4">
                <a href="{{ route('reports.transactions.export.pdf', request()->query()) }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center transition">
                    <i class="fa-solid fa-file-pdf mr-2"></i> Ekspor PDF
                </a>
                <a href="{{ route('reports.transactions.export.excel', request()->query()) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center transition">
                    <i class="fa-solid fa-file-excel mr-2"></i> Ekspor Excel
                </a>
            </div>

            <!-- Fitur Atur Sembunyikan Kolom (Admin Only) -->
            @if(Auth::user()->role === 'admin')
                <div class="bg-white dark:bg-gray-800 p-4 mt-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Atur Sembunyikan Kolom untuk Non-Admin</h3>
                    <form action="{{ route('settings.apply-default-hidden-transactions') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kolom yang Disembunyikan</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach(['product', 'type', 'quantity', 'date', 'status', 'notes', 'user'] as $column)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="default_hidden_columns_transactions[]" value="{{ $column }}" {{ in_array($column, $default_hidden_columns_transactions ?? []) ? 'checked' : '' }} class="mr-2">
                                        {{ ucfirst(str_replace('_', ' ', $column)) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sembunyikan untuk Role</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach(['manager', 'staff'] as $role)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="default_hidden_for_transactions[]" value="{{ $role }}" {{ in_array($role, $default_hidden_for_transactions ?? []) ? 'checked' : '' }} class="mr-2">
                                        {{ ucfirst($role) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            Terapkan Pengaturan Sembunyi Default
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>