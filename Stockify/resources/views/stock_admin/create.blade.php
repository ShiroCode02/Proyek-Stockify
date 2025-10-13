<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ $type === 'out' ? 'Transaksi Barang Keluar' : 'Transaksi Barang Masuk' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('stock-transactions.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="type" value="{{ $type }}">

                    <!-- Produk -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Produk</label>
                        <select name="product_id" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-stock="{{ $product->stock }}">
                                    {{ $product->name }} (Stok: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah</label>
                        <input type="number" name="quantity" min="1" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500"
                               id="quantity" oninput="checkStock()">
                        @error('quantity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p id="stockWarning" class="text-orange-600 text-xs mt-1 hidden">Stok tidak mencukupi!</p>
                    </div>

                    <!-- Supplier (hanya untuk masuk) -->
                    @if($type === 'in')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Supplier</label>
                            <select name="supplier_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Tanggal -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
                        <input type="date" name="date" value="{{ old('date') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500">
                        @error('date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                        <select name="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500">
                            <option value="completed" selected>Selesai</option>
                            <option value="pending">Pending</option>
                            <option value="canceled">Dibatalkan</option>
                        </select>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Catatan</label>
                        <textarea name="notes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Simpan Transaksi
                        </button>
                        <a href="{{ route('stock-transactions.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function checkStock() {
            const select = document.querySelector('select[name="product_id"]');
            const input = document.getElementById('quantity');
            const warning = document.getElementById('stockWarning');
            const type = '{{ $type }}';

            if (input && select) {
                const stock = parseInt(select.options[select.selectedIndex].dataset.stock || 0);
                const quantity = parseInt(input.value || 0);

                if (type === 'out' && quantity > stock) {
                    warning.classList.remove('hidden');
                    input.classList.add('border-red-500');
                } else {
                    warning.classList.add('hidden');
                    input.classList.remove('border-red-500');
                }
            }
        }
    </script>
    @endpush
</x-app-layout>