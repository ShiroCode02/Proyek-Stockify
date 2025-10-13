<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-xl p-6 shadow-md hover:shadow-2xl transition-all duration-300">
                <a href="{{ route('users.create') }}" class="mb-4 inline-block bg-blue-600 dark:bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-800">Tambah Pengguna</a>
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 rounded">{{ session('success') }}</div>
                @endif
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
                            <th class="p-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-gray-700 dark:text-gray-300">Nama</th>
                            <th class="p-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-gray-700 dark:text-gray-300">Email</th>
                            <th class="p-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-gray-700 dark:text-gray-300">Role</th>
                            <th class="p-3 border-b-2 border-gray-200 dark:border-gray-600 text-left text-gray-700 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-blue-900/50 dark:hover:to-indigo-900/50 transition-colors duration-200">
                                <td class="p-3 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300">{{ $user->name }}</td>
                                <td class="p-3 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300">{{ $user->email }}</td>
                                <td class="p-3 border-b border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300">{{ ucfirst($user->role) }}</td>
                                <td class="p-3 border-b border-gray-200 dark:border-gray-600">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-500 mr-2">Edit</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 border-b border-gray-200 dark:border-gray-600 text-center text-gray-500 dark:text-gray-300">
                                    Belum ada pengguna
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>