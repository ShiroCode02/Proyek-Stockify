<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight flex items-center">
            {{ __('Daftar Produk') }}
            <span class="ml-2 inline-block px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs font-semibold rounded-full animate-pulse-slow">
                {{ $products->count() }} Produk
            </span>
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Menu Tambahan untuk Kategori dan Supplier --}}
            <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
                @if(Auth::user()->role === 'admin')
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('categories.index') }}" 
                           class="bg-indigo-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-indigo-600 transition duration-200">
                            Kelola Kategori
                        </a>
                        <a href="{{ route('suppliers.index') }}" 
                           class="bg-purple-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-purple-600 transition duration-200">
                            Kelola Supplier
                        </a>
                    </div>
                @endif
                <input type="text" id="search" 
                       class="w-full sm:w-64 px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition duration-200"
                       placeholder="Cari produk...">
            </div>

            {{-- Tombol Tambah, Import, Export, dan Galeri --}}
            <div class="mb-6 flex flex-wrap gap-4 items-center">
                @if(in_array(Auth::user()->role, ['admin', 'manager', 'staff']))
                    <a href="{{ route('products.create') }}" 
                       class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-lg shadow-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i> Tambah Produk
                    </a>
                @endif
                <a href="{{ route('gallery.index') }}"
                   class="bg-gradient-to-r from-pink-500 to-pink-600 text-white px-6 py-3 rounded-lg shadow-md transform hover:scale-105 inline-flex items-center space-x-2">
                    <i class="fas fa-images"></i>
                    <span>Lihat Galeri</span>
                </a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('products.export') }}" 
                       class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-download mr-2"></i> Export Data
                    </a>
                    <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                        @csrf
                        <input type="file" name="file" accept=".xlsx,.csv" class="hidden" id="importFile">
                        <label for="importFile" 
                               class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-6 py-3 rounded-lg shadow-md cursor-pointer hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-upload mr-2"></i> Pilih File
                        </label>
                        <button type="submit" 
                                class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-6 py-3 rounded-lg shadow-md hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-cloud-upload-alt mr-2"></i> Import Data
                        </button>
                    </form>
                @endif
            </div>

            {{-- Notifikasi --}}
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

            {{-- Grid Produk --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($products->isEmpty())
                    <div class="col-span-full text-center p-12 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md animate-pulse">
                        <i class="fas fa-box-open text-4xl text-gray-400 dark:text-gray-200 mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-200">Belum ada produk. Tambah sekarang!</p>
                    </div>
                @else
                    @foreach($products as $product)
                        <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group relative">
                            @if(Auth::user()->role === 'admin')
                                <form action="{{ route('products.lock', $product->id) }}" method="POST" class="lock-form absolute top-2 right-2 z-10">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-3 py-1 rounded hover:from-yellow-600 hover:to-yellow-700 hover:shadow-lg transition-all duration-300 transform hover:scale-105"
                                            title="{{ $product->is_fixed ? 'Buka Kunci Produk' : 'Kunci Produk' }}">
                                        <i class="fas {{ $product->is_fixed ? 'fa-lock' : 'fa-lock-open' }} text-sm"></i>
                                    </button>
                                </form>
                            @endif
                            @if(!in_array('image', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                @else
                                    <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center mb-4">
                                        <i class="fas fa-image text-4xl text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                @endif
                            @endif
                            <div class="flex items-center justify-between mb-4">
                                @if(!in_array('name', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                                        {{ $product->name }}
                                        @if($product->is_fixed && Auth::user()->role !== 'admin')
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <span class="block">Produk Dikunci</span>
                                                <span class="block">(Terkunci)</span>
                                            </div>
                                        @endif
                                    </h3>
                                @else
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                                        [Nama Disembunyikan]
                                    </h3>
                                @endif
                                @if(!in_array('stock', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                    <span class="px-2 py-1 {{ $product->stock <= $product->minimum_stock ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }} text-sm rounded-full">
                                        {{ $product->stock <= $product->minimum_stock ? 'Stok Rendah' : 'Stok Aman' }}: {{ $product->stock }}
                                    </span>
                                @endif
                            </div>
                            @if(!in_array('category_id', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                <p class="text-gray-600 dark:text-gray-200 mb-2">Kategori: {{ $product->category->name ?? '-' }}</p>
                            @endif
                            @if(!in_array('supplier_id', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                <p class="text-gray-600 dark:text-gray-200 mb-2">Supplier: {{ $product->supplier->name ?? '-' }}</p>
                            @endif
                            @if(!in_array('sku', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                <p class="text-gray-600 dark:text-gray-200 mb-2">SKU: {{ $product->sku }}</p>
                            @endif
                            @if(!in_array('description', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                <p class="text-gray-600 dark:text-gray-200 mb-2">Deskripsi: {{ Str::limit($product->description, 30) }}</p>
                            @endif
                            @if(!in_array('minimum_stock', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                <p class="text-gray-600 dark:text-gray-200 mb-2">Minimum Stok: {{ $product->minimum_stock }}</p>
                            @endif
                            @if(!in_array('purchase_price', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                <p class="text-gray-800 dark:text-gray-100 font-semibold mb-2">Harga Beli: Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                            @endif
                            @if(!in_array('selling_price', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                <p class="text-gray-800 dark:text-gray-100 font-semibold mb-2">Harga Jual: Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                            @endif
                            @if(!in_array('attributes', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                                @if($product->attributes->isNotEmpty())
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        @foreach($product->attributes as $attribute)
                                            <span class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 px-2 py-1 rounded text-sm">
                                                {{ $attribute->name }}: {{ $attribute->value }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                            <div class="mt-4 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ route('products.show', $product->id) }}" 
                                   class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition duration-200">
                                    <i class="fas fa-eye mr-1"></i> Lihat
                                </a>
                                @if(Auth::user()->role === 'admin' || (in_array(Auth::user()->role, ['manager', 'staff']) && !$product->is_fixed))
                                    <a href="{{ route('products.edit', $product->id) }}" 
                                       class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition duration-200">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                                          onsubmit="return confirm('Yakin hapus produk ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition duration-200">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search');
            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                document.querySelectorAll('.grid > div').forEach(card => {
                    const name = card.querySelector('h3').textContent.toLowerCase();
                    card.style.display = name.includes(searchTerm) ? 'block' : 'none';
                });
            });

            // AJAX untuk tombol kunci
            document.querySelectorAll('.lock-form').forEach(form => {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const button = form.querySelector('button');
                    const productId = form.action.split('/').pop();
                    const isLocked = button.querySelector('i').classList.contains('fa-lock');

                    try {
                        const response = await fetch(form.action, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                        });
                        const data = await response.json();

                        if (data.success) {
                            // Update ikon dan tooltip
                            button.querySelector('i').classList.remove(isLocked ? 'fa-lock' : 'fa-lock-open');
                            button.querySelector('i').classList.add(isLocked ? 'fa-lock-open' : 'fa-lock');
                            button.title = isLocked ? 'Kunci Produk' : 'Buka Kunci Produk';
                            alert(data.message);
                        } else {
                            alert(data.error || 'Terjadi kesalahan saat mengunci/membuka produk.');
                        }
                    } catch (error) {
                        alert('Terjadi kesalahan: ' + error.message);
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>