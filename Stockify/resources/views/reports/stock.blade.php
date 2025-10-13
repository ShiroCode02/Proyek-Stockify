<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Stok Produk') }}
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

            <!-- Filter Laporan -->
            <div class="bg-white dark:bg-gray-800 p-4 mb-4 rounded-lg shadow-md">
                <form method="GET" action="{{ route('reports.stock') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                    <!-- Filter Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                        <select name="category_id" id="category_id" class="w-full border rounded px-2 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Supplier -->
                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
                        <select name="supplier_id" id="supplier_id" class="w-full border rounded px-2 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                            <option value="">Semua Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tanggal -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                        <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="w-full border rounded px-2 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                        <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="w-full border rounded px-2 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                    </div>

                    <!-- Pencarian Nama Produk -->
                    <div class="md:col-span-2">
                        <label for="keyword" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cari Produk</label>
                        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" placeholder="Masukkan nama produk..." class="w-full border rounded px-2 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                    </div>

                    <!-- Checkbox Filter Tambahan -->
                    <div class="md:col-span-2 flex space-x-4">
                        <label class="inline-flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="only_empty" class="mr-1" {{ request('only_empty') ? 'checked' : '' }}>
                            Hanya stok kosong
                        </label>
                        <label class="inline-flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="only_minimum" class="mr-1" {{ request('only_minimum') ? 'checked' : '' }}>
                            Hanya di bawah minimum
                        </label>
                    </div>

                    <!-- Tombol Filter -->
                    <div>
                        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Total -->
            <div class="bg-white dark:bg-gray-800 p-4 mb-4 rounded-lg shadow-md">
                <p class="text-gray-700 dark:text-gray-300">Total Stok: {{ $products->sum('stock') }}</p>
                <p class="text-gray-700 dark:text-gray-300">
                    Jumlah Produk dengan Stok Rendah: 
                    {{ $products->where('stock', '<=', 'minimum_stock')->count() }} 
                    ({{ number_format(($products->where('stock', '<=', 'minimum_stock')->count() / max($products->count(), 1)) * 100, 2) }}%)
                </p>
            </div>

            <!-- Tabel Laporan Stok -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6">
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                @if(!in_array('name', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                    <th class="p-2 border text-gray-700 dark:text-gray-300">Nama Produk</th>
                                @endif
                                @if(!in_array('category', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                    <th class="p-2 border text-gray-700 dark:text-gray-300">Kategori</th>
                                @endif
                                @if(!in_array('supplier', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                    <th class="p-2 border text-gray-700 dark:text-gray-300">Supplier</th>
                                @endif
                                @if(!in_array('stock', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                    <th class="p-2 border text-gray-700 dark:text-gray-300">Stok</th>
                                @endif
                                @if(!in_array('minimum_stock', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                    <th class="p-2 border text-gray-700 dark:text-gray-300">Minimum Stok</th>
                                @endif
                                @if(!in_array('purchase_price', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                    <th class="p-2 border text-gray-700 dark:text-gray-300">Harga Beli</th>
                                @endif
                                @if(!in_array('selling_price', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                    <th class="p-2 border text-gray-700 dark:text-gray-300">Harga Jual</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    @if(!in_array('name', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                        <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $product->name }}</td>
                                    @endif
                                    @if(!in_array('category', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                        <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $product->category->name ?? '-' }}</td>
                                    @endif
                                    @if(!in_array('supplier', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                        <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $product->supplier->name ?? '-' }}</td>
                                    @endif
                                    @if(!in_array('stock', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                        <td class="p-2 border {{ $product->stock <= $product->minimum_stock ? 'text-red-600 dark:text-red-400 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                            {{ $product->stock }}
                                        </td>
                                    @endif
                                    @if(!in_array('minimum_stock', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                        <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $product->minimum_stock }}</td>
                                    @endif
                                    @if(!in_array('purchase_price', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                        <td class="p-2 border text-gray-700 dark:text-gray-300">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                    @endif
                                    @if(!in_array('selling_price', $default_hidden_columns_stock ?? []) || !in_array(Auth::user()->role, $default_hidden_for_stock ?? []) || Auth::user()->role === 'admin')
                                        <td class="p-2 border text-gray-700 dark:text-gray-300">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 dark:text-gray-400 p-4">Tidak ada data produk yang cocok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 🔽 Tombol Ekspor Pindah ke Bawah Tabel -->
            <div class="flex gap-2 justify-end mt-4">
                <a href="{{ route('reports.stock.export.pdf') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center transition">
                    <i class="fa-solid fa-file-pdf mr-2"></i> Ekspor PDF
                </a>
                <a href="{{ route('reports.stock.export.excel') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center transition">
                    <i class="fa-solid fa-file-excel mr-2"></i> Ekspor Excel
                </a>
            </div>

            <!-- Fitur Atur Sembunyikan Kolom (Admin Only) -->
            @if(Auth::user()->role === 'admin')
                <div class="bg-white dark:bg-gray-800 p-4 mt-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Atur Sembunyikan Kolom untuk Non-Admin</h3>
                    <form action="{{ route('settings.apply-default-hidden-stock') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kolom yang Disembunyikan</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach(['name', 'category', 'supplier', 'stock', 'minimum_stock', 'purchase_price', 'selling_price'] as $column)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="default_hidden_columns_stock[]" value="{{ $column }}" {{ in_array($column, $default_hidden_columns_stock ?? []) ? 'checked' : '' }} class="mr-2">
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
                                        <input type="checkbox" name="default_hidden_for_stock[]" value="{{ $role }}" {{ in_array($role, $default_hidden_for_stock ?? []) ? 'checked' : '' }} class="mr-2">
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