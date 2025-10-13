<!-- resources/views/layouts/sidebar.blade.php -->
<aside 
    x-data="{ open: sidebarOpen }"
    x-bind:class="{ '-translate-x-full': !open, 'translate-x-0': open }"
    class="fixed top-0 left-0 z-40 w-64 h-screen bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-lg transition-transform duration-300 ease-in-out"
>
    <!-- Header Sidebar -->
    <div class="flex items-center justify-between px-4 py-3 border-b dark:border-gray-700">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/stockify-logo.png') }}" alt="Logo" class="h-8 w-auto">
            <span class="font-semibold text-lg text-gray-800 dark:text-gray-100">Stockify</span>
        </div>
        <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- User Info -->
    <div class="flex flex-col items-center mb-6 mt-6 text-center">
        @if(Auth::user()->avatar)
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="User Avatar" 
                class="w-16 h-16 rounded-full object-cover border-2 border-gray-300 dark:border-gray-700">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                alt="User Avatar" 
                class="w-16 h-16 rounded-full object-cover border-2 border-gray-300 dark:border-gray-700">
        @endif

        <p class="mt-2 font-semibold text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</p>
        <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">{{ Auth::user()->role }}</p>

        <a href="{{ route('profile.edit') }}" class="text-blue-500 text-sm hover:underline mt-1">
            Edit Profil
        </a>
    </div>

    <!-- Menu Sidebar -->
    <nav class="px-3 py-4 overflow-y-auto h-[calc(100%-12rem)]">
        <ul class="space-y-2">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" 
                    class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                    🏠 <span class="ml-2">Dashboard</span>
                </a>
            </li>

            <!-- Menu untuk Admin -->
            @if(Auth::check() && Auth::user()->role === 'admin')
                <li>
                    <a href="{{ route('products.index') }}" 
                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded {{ request()->routeIs('products.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                        📦 <span class="ml-2">Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('stock-transactions.index') }}" 
                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded {{ request()->routeIs('stock-transactions.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                        📊 <span class="ml-2">Stok Barang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('suppliers.index') }}" 
                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded {{ request()->routeIs('suppliers.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                        🚚 <span class="ml-2">Supplier</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}" 
                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded {{ request()->routeIs('users.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                        👥 <span class="ml-2">Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.stock') }}" 
                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded {{ request()->routeIs('reports.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                        📑 <span class="ml-2">Laporan</span>
                    </a>
                </li>
            @endif

            <!-- Menu untuk Manajer -->
            @if(Auth::check() && Auth::user()->role === 'manager')
                <li>
                    <a href="{{ route('products.index') }}" 
                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded {{ request()->routeIs('products.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                        📦 <span class="ml-2">Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('stock-transactions.index') }}" 
                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded {{ request()->routeIs('stock-transactions.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                        📊 <span class="ml-2">Stok Barang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('suppliers.index') }}" 
                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded {{ request()->routeIs('suppliers.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                        🚚 <span class="ml-2">Supplier</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.stock') }}" 
                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded {{ request()->routeIs('reports.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                        📑 <span class="ml-2">Laporan</span>
                    </a>
                </li>
            @endif

            <!-- Menu untuk Staff -->
            @if(Auth::check() && Auth::user()->role === 'staff')
                <li>
                    <a href="{{ route('stock.index') }}" 
                        class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded {{ request()->routeIs('stock.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                        📦 <span class="ml-2">Stok Barang</span>
                    </a>
                </li>
            @endif

            <!-- Logout -->
            <li class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-800 rounded">
                        🚪 <span class="ml-2">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
