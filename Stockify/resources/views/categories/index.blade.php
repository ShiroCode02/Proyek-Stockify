<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Kategori') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <a href="{{ route('categories.create') }}" 
           class="bg-green-500 dark:bg-green-700 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-green-600 dark:hover:bg-green-800">
            + Tambah Kategori
        </a>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="p-2 border text-gray-700 dark:text-gray-300">Nama</th>
                        <th class="p-2 border text-gray-700 dark:text-gray-300">Deskripsi</th>
                        <th class="p-2 border text-gray-700 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $category->name }}</td>
                            <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $category->description ?? '-' }}</td>
                            <td class="p-2 border">
                                <a href="{{ route('categories.edit', $category) }}" class="text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-500">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 dark:text-red-400 ml-2 hover:text-red-700 dark:hover:text-red-500">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-2 border text-center text-gray-500 dark:text-gray-300">Belum ada kategori</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>