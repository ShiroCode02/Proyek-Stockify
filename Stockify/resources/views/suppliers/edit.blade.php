<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Supplier') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Nama</label>
                        <input type="text" name="name" class="w-full border rounded p-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700" value="{{ $supplier->name }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Alamat</label>
                        <textarea name="address" class="w-full border rounded p-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">{{ $supplier->address }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Telepon</label>
                        <input type="text" name="phone" class="w-full border rounded p-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700" value="{{ $supplier->phone }}">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" class="w-full border rounded p-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700" value="{{ $supplier->email }}">
                    </div>
                    <button type="submit" class="bg-blue-500 dark:bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600 dark:hover:bg-blue-800">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>