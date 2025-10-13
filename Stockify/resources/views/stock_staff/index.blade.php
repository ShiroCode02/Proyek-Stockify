<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight flex items-center">
            Konfirmasi Stok
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 dark:from-gray-800 to-white dark:to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-visible shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Daftar Tugas Konfirmasi</h3>

                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 p-2 mb-4 rounded">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-4">{{ $errors->first() }}</div>
                @endif

                <!-- Barang Masuk Pending -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-600 dark:text-gray-400 mb-2">Barang Masuk</h4>
                    @if($pendingTransactions->where('type', 'in')->isNotEmpty())
                        <div class="grid gap-4">
                            @foreach($pendingTransactions->where('type', 'in') as $transaction)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-center">
                                        <div class="flex-1">
                                            <p class="font-medium">{{ $transaction->product->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah: {{ $transaction->quantity }} | Tanggal: {{ $transaction->date ? $transaction->date->format('d/m/Y') : 'N/A' }} | Catatan: {{ $transaction->notes ?? 'N/A' }} | Dibuat oleh: {{ $transaction->user->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('stock.confirm', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi barang masuk ini? Stok akan diperbarui.');">
                                                @csrf
                                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700 text-sm">Konfirmasi</button>
                                            </form>
                                            <form action="{{ route('stock.cancel', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan barang masuk ini? Status akan diubah ke canceled.');">
                                                @csrf
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 text-sm">Batalkan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada barang masuk yang perlu dikonfirmasi.</p>
                    @endif
                </div>

                <!-- Barang Keluar Pending -->
                <div class="mb-6">
                    <h4 class="text-md font-medium text-gray-600 dark:text-gray-400 mb-2">Barang Keluar</h4>
                    @if($pendingTransactions->where('type', 'out')->isNotEmpty())
                        <div class="grid gap-4">
                            @foreach($pendingTransactions->where('type', 'out') as $transaction)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-center">
                                        <div class="flex-1">
                                            <p class="font-medium">{{ $transaction->product->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah: {{ $transaction->quantity }} | Tanggal: {{ $transaction->date ? $transaction->date->format('d/m/Y') : 'N/A' }} | Catatan: {{ $transaction->notes ?? 'N/A' }} | Dibuat oleh: {{ $transaction->user->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('stock.confirm', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi barang keluar ini? Stok akan dikurangi.');">
                                                @csrf
                                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700 text-sm">Konfirmasi</button>
                                            </form>
                                            <form action="{{ route('stock.cancel', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan barang keluar ini? Status akan diubah ke canceled.');">
                                                @csrf
                                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 text-sm">Batalkan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Tidak ada barang keluar yang perlu dikonfirmasi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>