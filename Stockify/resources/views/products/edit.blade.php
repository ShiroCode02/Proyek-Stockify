<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight flex items-center">
            {{ __('Edit Produk: ' . $product->name) }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 dark:from-gray-800 to-white dark:to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-visible shadow-lg dark:shadow-md sm:rounded-lg p-6">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-6">
                        <!-- Nama Produk -->
                        @if(!in_array('name', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Produk</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white placeholder:text-gray-400 bg-white dark:bg-gray-700"
                                    placeholder="Contoh: Kaos Polos"
                                    @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('name', $product->locked_fields ?? [])) readonly @endif>
                                @error('name') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- SKU -->
                        @if(!in_array('sku', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">SKU</label>
                                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white placeholder:text-gray-400 bg-white dark:bg-gray-700"
                                    placeholder="Contoh: KPS001"
                                    @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('sku', $product->locked_fields ?? [])) readonly @endif>
                                @error('sku') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- Deskripsi -->
                        @if(!in_array('description', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                <textarea name="description"
                                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 h-24 resize-y text-gray-700 dark:text-white placeholder:text-gray-400 bg-white dark:bg-gray-700"
                                        placeholder="Contoh: Kaos katun berkualitas tinggi"
                                        @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('description', $product->locked_fields ?? [])) readonly @endif>{{ old('description', $product->description) }}</textarea>
                                @error('description') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- Kategori -->
                        @if(!in_array('category_id', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                                <select name="category_id" 
                                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                        @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('category_id', $product->locked_fields ?? [])) disabled @endif>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- Supplier -->
                        @if(!in_array('supplier_id', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
                                <select name="supplier_id" 
                                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                        @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('supplier_id', $product->locked_fields ?? [])) disabled @endif>
                                    <option value="">Pilih Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- Stok -->
                        @if(!in_array('stock', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stok Awal</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white placeholder:text-gray-400 bg-white dark:bg-gray-700"
                                    placeholder="Contoh: 100"
                                    @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('stock', $product->locked_fields ?? [])) readonly @endif>
                                @error('stock') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- Minimum Stok -->
                        @if(!in_array('minimum_stock', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Minimum Stok</label>
                                <input type="number" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}"
                                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white placeholder:text-gray-400 bg-white dark:bg-gray-700"
                                    placeholder="Contoh: 10"
                                    @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('minimum_stock', $product->locked_fields ?? [])) readonly @endif>
                                @error('minimum_stock') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- Harga Beli -->
                        @if(!in_array('purchase_price', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Beli</label>
                                <input type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}"
                                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white placeholder:text-gray-400 bg-white dark:bg-gray-700"
                                    placeholder="Contoh: 50000"
                                    @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('purchase_price', $product->locked_fields ?? [])) readonly @endif>
                                @error('purchase_price') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- Harga Jual -->
                        @if(!in_array('selling_price', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Jual</label>
                                <input type="number" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}"
                                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white placeholder:text-gray-400 bg-white dark:bg-gray-700"
                                    placeholder="Contoh: 75000"
                                    @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('selling_price', $product->locked_fields ?? [])) readonly @endif>
                                @error('selling_price') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- Gambar Produk -->
                        @if(!in_array('image', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Produk</label>
                                <input type="file" name="image"
                                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-white file:bg-white file:border-0 file:mr-4 file:py-2 file:px-4 file:rounded-full file:text-sm file:font-semibold file:text-blue-700 dark:file:bg-gray-800 dark:file:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                                    @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('image', $product->locked_fields ?? [])) disabled @endif>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
                                @error('image') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mt-2 w-32 h-32 object-cover rounded">
                                    <div class="mt-2">
                                        <label class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                            <input type="checkbox" name="remove_image" value="1" class="mr-2"
                                                @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('image', $product->locked_fields ?? [])) disabled @endif>
                                            Hapus Gambar
                                        </label>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Atribut -->
                        @if(!in_array('attributes', $product->hidden_fields ?? []) || !in_array(Auth::user()->role, $product->hidden_for ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Atribut (contoh: Ukuran/Warna/Berat)</label>
                                <div id="attributes-container" class="space-y-4 mt-2">
                                    @foreach($product->attributes as $index => $attribute)
                                        <div class="flex space-x-4">
                                            <input type="text" name="attributes[{{ $index }}][name]" value="{{ old("attributes.$index.name", $attribute->name) }}"
                                                class="flex-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                                placeholder="Nama Atribut (contoh: Ukuran)"
                                                @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('attributes', $product->locked_fields ?? [])) readonly @endif>
                                            <input type="text" name="attributes[{{ $index }}][value]" value="{{ old("attributes.$index.value", $attribute->value) }}"
                                                class="flex-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                                placeholder="Nilai Atribut (contoh: M)"
                                                @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('attributes', $product->locked_fields ?? [])) readonly @endif>
                                            <button type="button" class="remove-attribute bg-red-500 text-white px-2 py-1 rounded-lg hover:bg-red-600 transition duration-200"
                                                @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('attributes', $product->locked_fields ?? [])) disabled @endif>Hapus</button>
                                        </div>
                                    @endforeach
                                    <button type="button" id="add-attribute" class="bg-blue-600 dark:bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition duration-200"
                                        @if(in_array(Auth::user()->role, $product->locked_for ?? []) && in_array('attributes', $product->locked_fields ?? [])) disabled @endif>Tambah Atribut</button>
                                </div>
                                @error('attributes.*') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <!-- Pengaturan Kunci (Admin Only) -->
                        @if(Auth::user()->role === 'admin')
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Pengaturan Kunci Produk</h3>
                                <div class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-lock mr-2"></i>Kunci Produk (Tidak Bisa Diedit/Dihapus)
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_fixed" id="is_fixed" value="1" {{ old('is_fixed', $product->is_fixed) ? 'checked' : '' }}
                                            class="mr-2 rounded h-5 w-5 text-blue-600 dark:bg-gray-800 focus:ring-blue-500">
                                        <span class="text-gray-600 dark:text-gray-200">Aktifkan penguncian produk</span>
                                    </label>
                                    @error('is_fixed') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-shield-alt mr-2"></i>Field yang Dikunci
                                    </label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach(['name', 'sku', 'description', 'category_id', 'supplier_id', 'stock', 'minimum_stock', 'purchase_price', 'selling_price', 'image', 'attributes'] as $field)
                                            <label class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded transition-colors duration-200">
                                                <input type="checkbox" name="locked_fields[]" value="{{ $field }}"
                                                    {{ in_array($field, old('locked_fields', $product->locked_fields ?? [])) ? 'checked' : '' }}
                                                    class="mr-2 rounded h-5 w-5 text-blue-600 dark:bg-gray-800 focus:ring-blue-500">
                                                <span class="text-gray-600 dark:text-gray-200">{{ ucfirst(str_replace('_', ' ', $field)) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('locked_fields') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-users mr-2"></i>Batasi untuk Role
                                    </label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach(['manager', 'staff'] as $role)
                                            <label class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded transition-colors duration-200">
                                                <input type="checkbox" name="locked_for[]" value="{{ $role }}"
                                                    {{ in_array($role, old('locked_for', $product->locked_for ?? [])) ? 'checked' : '' }}
                                                    class="mr-2 rounded h-5 w-5 text-blue-600 dark:bg-gray-800 focus:ring-blue-500">
                                                <span class="text-gray-600 dark:text-gray-200">{{ ucfirst($role) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('locked_for') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Pengaturan Sembunyikan Field</h3>
                                    <div class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-eye-slash mr-2"></i>Field yang Disembunyikan
                                        </label>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach(['name', 'sku', 'description', 'category_id', 'supplier_id', 'stock', 'minimum_stock', 'purchase_price', 'selling_price', 'image', 'attributes'] as $field)
                                                <label class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded transition-colors duration-200">
                                                    <input type="checkbox" name="hidden_fields[]" value="{{ $field }}"
                                                        {{ in_array($field, old('hidden_fields', $product->hidden_fields ?? [])) ? 'checked' : '' }}
                                                        class="mr-2 rounded h-5 w-5 text-blue-600 dark:bg-gray-800 focus:ring-blue-500">
                                                    <span class="text-gray-600 dark:text-gray-200">{{ ucfirst(str_replace('_', ' ', $field)) }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('hidden_fields') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-users mr-2"></i>Sembunyikan untuk Role
                                        </label>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach(['manager', 'staff'] as $role)
                                                <label class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded transition-colors duration-200">
                                                    <input type="checkbox" name="hidden_for[]" value="{{ $role }}"
                                                        {{ in_array($role, old('hidden_for', $product->hidden_for ?? [])) ? 'checked' : '' }}
                                                        class="mr-2 rounded h-5 w-5 text-blue-600 dark:bg-gray-800 focus:ring-blue-500">
                                                    <span class="text-gray-600 dark:text-gray-200">{{ ucfirst($role) }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('hidden_for') <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 dark:from-green-600 dark:to-green-700 text-white px-6 py-3 rounded-lg shadow-md hover:from-green-600 hover:to-green-700 transition-all duration-300">
                            <i class="fas fa-save mr-2"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const addButton = document.getElementById('add-attribute');
                const container = document.getElementById('attributes-container');

                if (addButton && container) {
                    addButton.addEventListener('click', function () {
                        const index = container.getElementsByClassName('flex').length;
                        const newAttribute = `
                            <div class="flex space-x-4">
                                <input type="text" name="attributes[${index}][name]" 
                                       class="flex-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                       placeholder="Nama Atribut (contoh: Ukuran)">
                                <input type="text" name="attributes[${index}][value]" 
                                       class="flex-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                       placeholder="Nilai Atribut (contoh: M)">
                                <button type="button" class="remove-attribute bg-red-500 text-white px-2 py-1 rounded-lg hover:bg-red-600 transition duration-200">Hapus</button>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', newAttribute);
                    });

                    container.addEventListener('click', function (e) {
                        if (e.target.classList.contains('remove-attribute')) {
                            e.target.parentElement.remove();
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>