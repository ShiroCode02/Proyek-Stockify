<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Galeri Produk') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        
                        {{-- Gambar Produk --}}
                        @if($product->image)
                            <img 
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-48 object-cover"
                            >
                        @else
                            <div class="w-full h-48 flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-300 italic">
                                Tidak ada gambar
                            </div>
                        @endif

                        {{-- Info Produk --}}
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">
                                {{ $product->name }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Stok: {{ $product->stock }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Harga:
                                <span class="font-medium text-green-600 dark:text-green-400">
                                    Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                </span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-gray-500 dark:text-gray-300">
                Belum ada produk yang tersedia untuk ditampilkan.
            </div>
        @endif
    </div>
</x-app-layout>
