<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Halaman Stok</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 rounded">{{ session('success') }}</div>
                @endif

                <!-- Tombol Akses Cepat -->
                <div class="mb-6 flex space-x-4">
                    <a href="{{ route('stock.opname') }}"
                       class="bg-blue-600 dark:bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-800">
                        Stock Opname
                    </a>
                    <a href="{{ route('stock.minimum') }}"
                       class="bg-green-600 dark:bg-green-700 text-white px-4 py-2 rounded hover:bg-green-700 dark:hover:bg-green-800">
                        Pengaturan Stok Minimum
                    </a>
                </div>

                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Catatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Stok Saat Ini</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($transactions as $transaction)
                            <?php
                                $product = $transaction->product;
                                $isBelowMinimum = $product && $product->stock !== null && $product->minimum_stock !== null && $product->stock < $product->minimum_stock;
                            ?>
                            <tr class="{{ $isBelowMinimum ? 'bg-red-100 dark:bg-red-900/30' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $product->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ ucfirst($transaction->type) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $transaction->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $transaction->user->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ ucfirst($transaction->status) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $transaction->notes ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap {{ $isBelowMinimum ? 'text-red-600 dark:text-red-400 font-bold' : 'text-gray-700 dark:text-gray-300' }}">
                                    {{ $product->stock ?? 'N/A' }} {{ $isBelowMinimum ? '(Di bawah minimum)' : '' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>