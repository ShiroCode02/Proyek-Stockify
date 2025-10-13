<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight flex items-center">
            {{ $type === 'in' ? 'Tambah Barang Masuk' : 'Tambah Barang Keluar' }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 dark:from-gray-800 to-white dark:to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-visible shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('stock.' . ($type === 'in' ? 'storeIn' : 'storeOut')) }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">
                    <div class="grid gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produk</label>
                            <select name="product_id" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700" required>
                                <option value="">Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                            <input type="number" name="quantity" value="{{ old('quantity') }}"
                                   class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700"
                                   min="1" required>
                            @error('quantity')
                                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan</label>
                            <textarea name="notes" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 h-24 resize-y text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-{{ $type === 'in' ? 'blue' : 'red' }}-600 text-white px-4 py-2 rounded-lg hover:bg-{{ $type === 'in' ? 'blue' : 'red' }}-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>