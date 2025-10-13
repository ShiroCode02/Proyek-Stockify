<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Supplier') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form method="POST" action="{{ route('suppliers.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Nama</label>
                        <input type="text" name="name" class="w-full border rounded p-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Alamat</label>
                        <textarea name="address" class="w-full border rounded p-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Telepon</label>
                        <input type="text" name="phone" class="w-full border rounded p-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" class="w-full border rounded p-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                    </div>
                    <button type="submit" class="bg-green-500 dark:bg-green-700 text-white px-4 py-2 rounded hover:bg-green-600 dark:hover:bg-green-800">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>