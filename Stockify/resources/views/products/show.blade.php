<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Detail Produk: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-800">
                <div class="flex flex-col md:flex-row items-start justify-between gap-6 mb-6">
                    <div class="w-full md:w-1/3">
                        {{-- Tampilkan Gambar hanya jika diizinkan --}}
                        @if((!in_array('image', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin') && config('settings.show_product_image') === 'yes' && $product->image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-xl shadow-md transition-transform duration-300 hover:scale-105">
                            </div>
                        @else
                            <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-xl flex items-center justify-center text-gray-500 dark:text-gray-400">
                                No Image Available
                            </div>
                        @endif
                    </div>
                    <div class="w-full md:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 col-span-2">
                            {{ $product->name }}
                        </h3>
                        @if(!in_array('stock', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div class="col-span-2">
                                <span class="px-3 py-1 rounded-full text-sm" :class="{ 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200': $product->stock > ($product->minimum_stock ?? 0), 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200': $product->stock <= ($product->minimum_stock ?? 0) }">
                                    Stok: {{ $product->stock }} ({{ $product->stock <= ($product->minimum_stock ?? 0) ? 'Stok Rendah' : 'Stok Aman' }})
                                </span>
                            </div>
                        @endif
                        @if(!in_array('sku', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <p class="text-gray-700 dark:text-gray-300"><strong>SKU:</strong> {{ $product->sku ?? '-' }}</p>
                        @endif
                        @if(!in_array('category_id', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <p class="text-gray-700 dark:text-gray-300"><strong>Kategori:</strong> {{ $product->category->name ?? '-' }}</p>
                        @endif
                        @if(!in_array('supplier_id', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <p class="text-gray-700 dark:text-gray-300"><strong>Supplier:</strong> {{ $product->supplier->name ?? '-' }}</p>
                        @endif
                        @if(!in_array('purchase_price', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <p class="text-gray-700 dark:text-gray-300"><strong>Harga Beli:</strong> <span class="text-yellow-600 dark:text-yellow-400 font-semibold">Rp {{ number_format($product->purchase_price ?? 0, 0, ',', '.') }}</span></p>
                        @endif
                        @if(!in_array('selling_price', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <p class="text-gray-700 dark:text-gray-300"><strong>Harga Jual:</strong> <span class="text-green-600 dark:text-green-400 font-semibold">Rp {{ number_format($product->selling_price ?? 0, 0, ',', '.') }}</span></p>
                        @endif
                        @if(!in_array('minimum_stock', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <p class="text-gray-700 dark:text-gray-300"><strong>Minimum Stok:</strong> {{ $product->minimum_stock ?? 'N/A' }}</p>
                        @endif
                        @if(!in_array('description', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <p class="text-gray-700 dark:text-gray-300"><strong>Deskripsi:</strong> {{ $product->description ?? '-' }}</p>
                        @endif
                        <p class="text-gray-700 dark:text-gray-300"><strong>Dibuat Pada:</strong> {{ $product->created_at->format('d M Y H:i') ?? '-' }}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Terakhir Diperbarui:</strong> {{ $product->updated_at->format('d M Y H:i') ?? '-' }}</p>
                    </div>
                </div>

                @if((!in_array('attributes', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin') && $product->attributes->isNotEmpty())
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">Atribut Produk:</h4>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->attributes as $attribute)
                                <span class="inline-block bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-100 px-4 py-2 rounded-full text-sm shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                                    {{ $attribute->name }}: {{ $attribute->value }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-6 flex justify-start">
                    <a href="{{ route('products.index') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>