<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight flex items-center">
            {{ __('Manajemen Stok') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 dark:from-gray-800 to-white dark:to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-visible shadow-xl sm:rounded-lg p-6">
                <div class="mb-6">
                    <a href="{{ route('stock.in') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Tambah Barang Masuk</a>
                    <a href="{{ route('stock.out') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 ml-2">Tambah Barang Keluar</a>
                    <a href="{{ route('stock.opname') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 ml-2">Stock Opname</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 p-2 mb-4 rounded">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <!-- Table Pending -->
                <div class="mb-6">
                    <h3 class="text-xl font-bold mb-4">Transaksi Pending</h3>
                    @if($pendingTransactions->isEmpty())
                        <p>Tidak ada transaksi pending.</p>
                    @else
                        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                            <thead class="bg-gray-200 dark:bg-gray-700">
                                <tr>
                                    <th class="py-2 px-4">Produk</th>
                                    <th class="py-2 px-4">Tipe</th>
                                    <th class="py-2 px-4">Jumlah</th>
                                    <th class="py-2 px-4">Catatan</th>
                                    <th class="py-2 px-4">Tanggal</th>
                                    <th class="py-2 px-4">Dibuat Oleh</th>
                                    <th class="py-2 px-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingTransactions as $pending)
                                    <tr class="border-b dark:border-gray-600">
                                        <td class="py-2 px-4">{{ $pending->product->name }}</td>
                                        <td class="py-2 px-4">
                                            <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded">{{ ucfirst($pending->type) }}</span>
                                        </td>
                                        <td class="py-2 px-4">{{ $pending->quantity }}</td>
                                        <td class="py-2 px-4">{{ $pending->notes ?? 'N/A' }}</td>
                                        <td class="py-2 px-4">{{ $pending->date ? $pending->date->format('d/m/Y') : 'N/A' }}</td>
                                        <td class="py-2 px-4">{{ $pending->user->name ?? 'N/A' }}</td>
                                        <td class="py-2 px-4">
                                            <form action="{{ route('stock.confirm', $pending->id) }}" method="POST" class="inline mr-2" onsubmit="return confirm('Konfirmasi transaksi ini? Stok akan diperbarui.');">
                                                @csrf
                                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700 text-sm">Konfirmasi</button>
                                            </form>
                                            <form action="{{ route('stock.cancel', $pending->id) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan transaksi ini? Status akan diubah ke canceled.');">
                                                @csrf
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 text-sm ml-1">Batalkan</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="py-2 px-4">Nama Produk</th>
                            <th class="py-2 px-4">Stok Tersedia</th>
                            <th class="py-2 px-4">Stok Minimum</th>
                            <th class="py-2 px-4">Status</th>
                            <th class="py-2 px-4">Supplier</th>
                            <th class="py-2 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr class="border-b dark:border-gray-600">
                                <td class="py-2 px-4">{{ $product->name }}</td>
                                <td class="py-2 px-4">{{ $product->stock }}</td>
                                <td class="py-2 px-4">{{ $product->minimum_stock ?? 'N/A' }}</td>
                                <td class="py-2 px-4">
                                    @if($product->minimum_stock && $product->stock <= $product->minimum_stock)
                                        <span class="text-red-600">Stok Rendah</span>
                                    @else
                                        <span class="text-green-600">Stok Aman</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4">
                                    @if($product->supplier_id)
                                        {{ $product->supplier->name ?? 'Tidak ada supplier' }}
                                    @else
                                        Tidak ada supplier
                                    @endif
                                </td>
                                <td class="py-2 px-4">
                                    <a href="{{ route('stock.in') }}?product_id={{ $product->id }}" class="text-blue-600 hover:underline">Masuk</a>
                                    <a href="{{ route('stock.out') }}?product_id={{ $product->id }}" class="text-red-600 hover:underline ml-2">Keluar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>