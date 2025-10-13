<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Kategori') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-md mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Kategori</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                    <textarea name="description" id="description"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700"></textarea>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('categories.index') }}" class="mr-3 text-gray-600 dark:text-gray-400">Batal</a>
                    <button type="submit" class="bg-green-500 dark:bg-green-700 text-white px-4 py-2 rounded hover:bg-green-600 dark:hover:bg-green-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>