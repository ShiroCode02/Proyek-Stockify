<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight flex items-center">
            {{ __('Tambah Produk Baru') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 dark:from-gray-800 to-white dark:to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-visible shadow-xl sm:rounded-lg p-6">
                <!-- Form untuk Simpan Produk -->
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="grid gap-6">
                        <!-- Nama Produk -->
                        @if(!in_array('name', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Produk</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700 autofill:bg-gray-700 autofill:text-white"
                                       placeholder="Contoh: Kaos Polos" autocomplete="off" {{ in_array('name', $default_hidden_fields ?? []) ? '' : 'required' }}>
                                @error('name')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- SKU -->
                        @if(!in_array('sku', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">SKU</label>
                                <input type="text" name="sku" value="{{ old('sku') }}"
                                       class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                       placeholder="Contoh: KPS001" {{ in_array('sku', $default_hidden_fields ?? []) ? '' : 'required' }}>
                                @error('sku')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Deskripsi -->
                        @if(!in_array('description', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                <textarea name="description"
                                          class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 h-24 resize-y text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                          placeholder="Contoh: Kaos katun berkualitas tinggi">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Kategori -->
                        @if(!in_array('category_id', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                                <select name="category_id"
                                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 appearance-none text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                        {{ in_array('category_id', $default_hidden_fields ?? []) ? '' : 'required' }}>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Supplier -->
                        @if(!in_array('supplier_id', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
                                <select name="supplier_id"
                                        class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 appearance-none text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                        {{ in_array('supplier_id', $default_hidden_fields ?? []) ? '' : 'required' }}>
                                    <option value="">Pilih Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Stok Awal -->
                        @if(!in_array('stock', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stok Awal</label>
                                <input type="number" name="stock" value="{{ old('stock') }}" min="0"
                                       class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                       placeholder="Contoh: 100" {{ in_array('stock', $default_hidden_fields ?? []) ? '' : 'required' }}>
                                @error('stock')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Minimum Stok -->
                        @if(!in_array('minimum_stock', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Minimum Stok</label>
                                <input type="number" name="minimum_stock" value="{{ old('minimum_stock') }}" min="0"
                                       class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                       placeholder="Contoh: 10" {{ in_array('minimum_stock', $default_hidden_fields ?? []) ? '' : 'required' }}>
                                @error('minimum_stock')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Harga Beli -->
                        @if(!in_array('purchase_price', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Beli</label>
                                <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" min="0" step="0.01"
                                       class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                       placeholder="Contoh: 50000" {{ in_array('purchase_price', $default_hidden_fields ?? []) ? '' : 'required' }}>
                                @error('purchase_price')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Harga Jual -->
                        @if(!in_array('selling_price', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Jual</label>
                                <input type="number" name="selling_price" value="{{ old('selling_price') }}" min="0" step="0.01"
                                       class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                       placeholder="Contoh: 75000" {{ in_array('selling_price', $default_hidden_fields ?? []) ? '' : 'required' }}>
                                @error('selling_price')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Gambar Produk -->
                        @if(!in_array('image', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Produk</label>
                                <input type="file" name="image"
                                       class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700 file:bg-white file:border-0 file:mr-4 file:py-2 file:px-4 file:rounded-full file:text-sm file:font-semibold file:text-blue-700 dark:file:bg-gray-800 dark:file:text-white" accept="image/*">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Unggah gambar dalam format JPEG, PNG, GIF, atau WEBP (maks. 2MB).</p>
                                @error('image')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Atribut -->
                        @if(!in_array('attributes', $default_hidden_fields ?? []) || Auth::user()->role === 'admin')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Atribut (contoh: Ukuran/Warna/Berat)</label>
                                <div id="attributes-container" class="space-y-4 mt-2">
                                    <div class="flex space-x-4">
                                        <input type="text" name="attributes[0][name]"
                                               class="flex-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                               placeholder="Nama Atribut (misal: Ukuran)">
                                        <input type="text" name="attributes[0][value]"
                                               class="flex-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700"
                                               placeholder="Nilai Atribut (misal: M)">
                                        <button type="button"
                                                class="remove-attribute bg-red-500 text-white px-2 py-1 rounded-lg hover:bg-red-600 transition duration-200">
                                            Hapus
                                        </button>
                                    </div>
                                    <button type="button" id="add-attribute"
                                            class="bg-blue-600 dark:bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition duration-200">
                                        Tambah Atribut
                                    </button>
                                </div>
                                @error('attributes.*')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <!-- Pengaturan Sembunyi untuk Produk Ini (Admin Only) -->
                        @if(Auth::user()->role === 'admin')
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Pengaturan Produk</h3>
                                <!-- Checkbox untuk mengaktifkan pengaturan sembunyi untuk produk ini -->
                                <div class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="apply_hidden_settings" id="apply_hidden_settings" value="1"
                                               class="mr-2 rounded h-5 w-5 text-blue-600 dark:bg-gray-800 focus:ring-blue-500">
                                        <span class="text-gray-600 dark:text-gray-200">Terapkan pengaturan sembunyi field untuk produk ini</span>
                                    </label>
                                </div>
                                <!-- Pengaturan Sembunyi untuk Produk Ini -->
                                <div id="product-hidden-settings" class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-eye-slash mr-2"></i>Field yang Disembunyikan untuk Produk Ini
                                    </label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach(['name', 'sku', 'description', 'category_id', 'supplier_id', 'stock', 'minimum_stock', 'purchase_price', 'selling_price', 'image', 'attributes'] as $field)
                                            <label class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded transition-colors duration-200">
                                                <input type="checkbox" name="hidden_fields[]" value="{{ $field }}"
                                                       {{ in_array($field, old('hidden_fields', [])) ? 'checked' : '' }}
                                                       class="mr-2 rounded h-5 w-5 text-blue-600 dark:bg-gray-800 focus:ring-blue-500">
                                                <span class="text-gray-600 dark:text-gray-200">{{ ucfirst(str_replace('_', ' ', $field)) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('hidden_fields')
                                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div id="product-hidden-for" class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-users mr-2"></i>Sembunyikan untuk Role (Produk Ini)
                                    </label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach(['manager', 'staff'] as $role)
                                            <label class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded transition-colors duration-200">
                                                <input type="checkbox" name="hidden_for[]" value="{{ $role }}"
                                                       {{ in_array($role, old('hidden_for', [])) ? 'checked' : '' }}
                                                       class="mr-2 rounded h-5 w-5 text-blue-600 dark:bg-gray-800 focus:ring-blue-500">
                                                <span class="text-gray-600 dark:text-gray-200">{{ ucfirst($role) }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('hidden_for')
                                        <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <!-- Tombol untuk Simpan Produk -->
                        <div class="flex space-x-4">
                            <button type="submit" name="action" value="save" class="bg-gradient-to-r from-green-500 to-green-600 dark:from-green-600 dark:to-green-700 text-white px-6 py-3 rounded-lg shadow-md hover:from-green-600 hover:to-green-700 transition-all duration-300">
                                <i class="fas fa-save mr-2"></i> Simpan Produk
                            </button>
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 dark:from-gray-600 dark:to-gray-700 text-white px-6 py-3 rounded-lg shadow-md hover:from-gray-600 hover:to-gray-700 transition-all duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                <!-- Form untuk Terapkan Pengaturan Sembunyi Default (Admin Only) -->
                @if(Auth::user()->role === 'admin')
                    <form action="{{ route('settings.apply-default-hidden') }}" method="POST" class="space-y-6 mt-6">
                        @csrf
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">Pengaturan Sembunyi Default</h3>
                            <!-- Pengaturan Sembunyi Default untuk Non-Admin -->
                            <div id="default-hidden-settings" class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-eye-slash mr-2"></i>Field yang Disembunyikan untuk Produk Baru Non-Admin
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach(['name', 'sku', 'description', 'category_id', 'supplier_id', 'stock', 'minimum_stock', 'purchase_price', 'selling_price', 'image', 'attributes'] as $field)
                                        <label class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded transition-colors duration-200">
                                            <input type="checkbox" name="default_hidden_fields[]" value="{{ $field }}"
                                                   {{ in_array($field, old('default_hidden_fields', $default_hidden_fields ?? [])) ? 'checked' : '' }}
                                                   class="mr-2 rounded h-5 w-5 text-blue-600 dark:bg-gray-800 focus:ring-blue-500">
                                            <span class="text-gray-600 dark:text-gray-200">{{ ucfirst(str_replace('_', ' ', $field)) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('default_hidden_fields')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div id="default-hidden-for" class="mb-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-users mr-2"></i>Sembunyikan untuk Role (Produk Baru Non-Admin)
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach(['manager', 'staff'] as $role)
                                        <label class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded transition-colors duration-200">
                                            <input type="checkbox" name="default_hidden_for[]" value="{{ $role }}"
                                                   {{ in_array($role, old('default_hidden_for', $default_hidden_for ?? [])) ? 'checked' : '' }}
                                                   class="mr-2 rounded h-5 w-5 text-blue-600 dark:bg-gray-800 focus:ring-blue-500">
                                            <span class="text-gray-600 dark:text-gray-200">{{ ucfirst($role) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('default_hidden_for')
                                    <p class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Tombol untuk Terapkan Pengaturan Sembunyi Default -->
                            <div class="flex space-x-4">
                                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 text-white px-6 py-3 rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 transition-all duration-300">
                                    <i class="fas fa-eye-slash mr-2"></i> Terapkan Pengaturan Sembunyi Default
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const addButton = document.getElementById('add-attribute');
                const container = document.getElementById('attributes-container');
                const applyHiddenSettings = document.getElementById('apply_hidden_settings');
                const productHiddenSettings = document.getElementById('product-hidden-settings');
                const productHiddenFor = document.getElementById('product-hidden-for');

                // Sembunyikan pengaturan sembunyi produk secara default
                if (productHiddenSettings && productHiddenFor) {
                    productHiddenSettings.style.display = 'none';
                    productHiddenFor.style.display = 'none';
                }

                // Tampilkan/sembunyikan pengaturan sembunyi produk berdasarkan checkbox
                if (applyHiddenSettings) {
                    applyHiddenSettings.addEventListener('change', function () {
                        if (this.checked) {
                            productHiddenSettings.style.display = 'block';
                            productHiddenFor.style.display = 'block';
                        } else {
                            productHiddenSettings.style.display = 'none';
                            productHiddenFor.style.display = 'none';
                        }
                    });
                }

                // Logika untuk atribut
                if (addButton && container) {
                    addButton.addEventListener('click', function () {
                        const index = container.getElementsByClassName('flex').length;
                        const newAttribute = `
                            <div class="flex space-x-4 mt-2">
                                <input type="text" name="attributes[${index}][name]" 
                                       class="flex-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700" 
                                       placeholder="Nama Atribut (misal: Ukuran)">
                                <input type="text" name="attributes[${index}][value]" 
                                       class="flex-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 text-gray-700 dark:text-white bg-white dark:bg-gray-700" 
                                       placeholder="Nilai Atribut (misal: M)">
                                <button type="button" class="remove-attribute bg-red-500 text-white px-2 py-1 rounded-lg hover:bg-red-600 transition duration-200">Hapus</button>
                            </div>`;
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