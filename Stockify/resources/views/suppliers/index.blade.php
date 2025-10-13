<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Supplier') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- ✅ Notifikasi --}}
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200 p-2 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-200 p-2 mb-4 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- ✅ Tombol ekspor & tambah --}}
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-2">
                <div class="flex flex-wrap gap-2">
                    {{-- Tombol ekspor --}}
                    <a href="{{ route('suppliers.export.pdf') }}"
                       class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm transition dark:bg-red-700 dark:hover:bg-red-800 flex items-center gap-1">
                        <i class="fa-solid fa-file-pdf"></i> Ekspor PDF
                    </a>
                    <a href="{{ route('suppliers.export.excel') }}"
                       class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded text-sm transition dark:bg-green-700 dark:hover:bg-green-800 flex items-center gap-1">
                        <i class="fa-solid fa-file-excel"></i> Ekspor Excel
                    </a>
                </div>

                {{-- Tombol tambah hanya admin --}}
                @can('admin')
                    <a href="{{ route('suppliers.create') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition dark:bg-blue-700 dark:hover:bg-blue-800">
                        + Tambah Supplier
                    </a>
                @endcan
            </div>

            {{-- ✅ Tabel daftar supplier --}}
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <table class="w-full border border-gray-300 dark:border-gray-700">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="p-2 border">No</th>
                            <th class="p-2 border">Nama Supplier</th>
                            <th class="p-2 border">Alamat</th>
                            <th class="p-2 border">Telepon</th>
                            <th class="p-2 border">Email</th>
                            @can('admin')
                                <th class="p-2 border text-center">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $index => $supplier)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="p-2 border text-center text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                                <td class="p-2 border text-gray-700 dark:text-gray-300 font-medium">{{ $supplier->name ?? '-' }}</td>
                                <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $supplier->address ?? '-' }}</td>
                                <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $supplier->phone ?? '-' }}</td>
                                <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $supplier->email ?? '-' }}</td>
                                @can('admin')
                                    <td class="p-2 border text-center">
                                        <a href="{{ route('suppliers.edit', $supplier) }}" 
                                           class="text-blue-500 dark:text-blue-400 hover:underline">Edit</a>
                                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-500 dark:text-red-400 ml-2 hover:underline"
                                                    onclick="return confirm('Yakin hapus supplier ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="@can('admin') 6 @else 5 @endcan" 
                                    class="text-center p-3 text-gray-500 dark:text-gray-400">
                                    Tidak ada data supplier
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
