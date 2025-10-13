<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Pengaturan Stok Minimum</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 p-2 mb-4 rounded">{{ session('success') }}</div>
                @endif
                <form action="{{ route('stock.updateMinimum') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produk</label>
                        <select name="product_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700" required>
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Minimum: {{ $product->minimum_stock ?? 0 }})</option>
                            @endforeach
                        </select>
                        @error('product_id') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stok Minimum Baru</label>
                        <input type="number" name="minimum_stock" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700" required>
                        @error('minimum_stock') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="bg-green-600 dark:bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-700 dark:hover:bg-green-800">Perbarui</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>