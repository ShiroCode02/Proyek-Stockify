<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigasi Laporan -->
            <nav class="bg-gray-100 dark:bg-gray-800 p-2 rounded-md mb-4">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('reports.stock') }}" class="{{ request()->routeIs('reports.stock') ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">Stok</a>
                    </li>
                    <li>
                        <a href="{{ route('reports.transactions') }}" class="{{ request()->routeIs('reports.transactions') ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">Transaksi</a>
                    </li>
                    @if(Auth::user()->role === 'admin')
                        <li>
                            <a href="{{ route('reports.users') }}" class="{{ request()->routeIs('reports.users') ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}">Aktivitas Pengguna</a>
                        </li>
                    @endif
                </ul>
            </nav>
            
            <!-- Filter Pengguna -->
            <div class="bg-white dark:bg-gray-800 p-4 mb-4 rounded-lg shadow-sm">
                <form method="GET" action="{{ route('reports.users') }}" class="flex space-x-4 items-end">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <select name="role" id="role" class="border rounded px-2 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }} class="text-gray-700 dark:text-gray-300">Admin</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }} class="text-gray-700 dark:text-gray-300">Manajer</option>
                            <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }} class="text-gray-700 dark:text-gray-300">Staff</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="p-2 border text-gray-700 dark:text-gray-300">Nama</th>
                                <th class="p-2 border text-gray-700 dark:text-gray-300">Email</th>
                                <th class="p-2 border text-gray-700 dark:text-gray-300">Role</th>
                                <th class="p-2 border text-gray-700 dark:text-gray-300">Jumlah Transaksi</th>
                                <th class="p-2 border text-gray-700 dark:text-gray-300">Tanggal Aktivitas Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $user->name }}</td>
                                    <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $user->email }}</td>
                                    <td class="p-2 border text-gray-700 dark:text-gray-300">{{ ucfirst($user->role) }}</td>
                                    <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $user->stock_transactions_count }}</td>
                                    <td class="p-2 border text-gray-700 dark:text-gray-300">{{ $user->updated_at ? $user->updated_at->format('d-m-Y H:i') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-2 border text-center text-gray-500 dark:text-gray-300">Belum ada pengguna</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>