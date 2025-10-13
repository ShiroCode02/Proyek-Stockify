<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Pengaturan Aplikasi
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-200 p-4 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Informasi Umum --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Informasi Umum</h3>
            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="app_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Aplikasi</label>
                        <input type="text" id="app_name" name="app_name" value="{{ old('app_name', $settings['app_name'] ?? 'Stockify') }}" 
                               class="mt-1 w-full border px-3 py-2 rounded bg-white dark:bg-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        @error('app_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="admin_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Admin</label>
                        <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email', $settings['admin_email'] ?? '') }}" 
                               class="mt-1 w-full border px-3 py-2 rounded bg-white dark:bg-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        @error('admin_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Logo Upload --}}
                <div class="mb-4">
                    <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Logo Aplikasi</label>
                    @if ($settings['logo_url'] ?? false)
                        <img src="{{ $settings['logo_url'] }}" alt="Logo Saat Ini" class="w-24 h-24 object-contain border rounded mb-2">
                        <p class="text-sm text-gray-500 mb-2">Logo saat ini. Upload file baru untuk mengganti.</p>
                    @else
                        <p class="text-sm text-gray-500 mb-2">Belum ada logo. Upload gambar (JPG, PNG, max 2MB).</p>
                    @endif
                    <input type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/gif" 
                           class="mt-1 w-full border px-3 py-2 rounded bg-white dark:bg-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('logo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        {{-- Tampilan --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Tampilan</h3>
            <form method="POST" action="{{ route('settings.update.display') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="flex flex-col space-y-3">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="dark_mode_default" value="1" {{ old('dark_mode_default', $settings['dark_mode_default'] ? 'checked' : '') }} class="form-checkbox text-blue-600 rounded border-gray-300 dark:border-gray-600 focus:ring-blue-500">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Aktifkan Dark Mode Default</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="show_logo_sidebar" value="1" {{ old('show_logo_sidebar', $settings['show_logo_sidebar'] ? 'checked' : '') }} class="form-checkbox text-blue-600 rounded border-gray-300 dark:border-gray-600 focus:ring-blue-500">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Tampilkan Logo di Sidebar</span>
                    </label>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Simpan Tampilan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>