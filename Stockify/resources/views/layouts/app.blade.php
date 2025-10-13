<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ 
        darkMode: localStorage.getItem('theme') === 'dark' || 
                  (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
        sidebarOpen: false 
      }"
      :class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', value => localStorage.setItem('theme', value ? 'dark' : 'light'));
              $watch('sidebarOpen', value => localStorage.setItem('sidebar', value ? 'open' : 'closed'))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Stockify') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-gray-100">

    <div class="min-h-screen flex bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">

        <!-- Tombol Toggle Sidebar -->
        <div class="fixed top-20 left-4 z-50">
            <button x-on:click="sidebarOpen = !sidebarOpen" 
                    class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-100 focus:outline-none bg-white dark:bg-gray-800 rounded-full p-2 shadow-md">
                <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                <svg x-show="sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- ✅ SIDEBAR --}}
        <aside id="sidebar" 
               class="fixed top-0 left-0 z-40 h-screen transition-transform -translate-x-full bg-white dark:bg-gray-800 shadow-md w-64"
               x-bind:class="{ 'translate-x-0': sidebarOpen }">
            
            {{-- Header Sidebar --}}
            <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/stockify-logo.png') }}" alt="Logo" class="h-8 w-auto">
                    <span class="font-semibold text-lg text-gray-800 dark:text-gray-100">Stockify</span>
                </div>
                <button @click="sidebarOpen = false" 
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Profil Pengguna --}}
            <div class="flex flex-col items-center text-center py-6 border-b border-gray-200 dark:border-gray-700">
                <img 
                    src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}" 
                    alt="User Avatar" 
                    class="w-16 h-16 rounded-full border-2 border-gray-300 dark:border-gray-600 mb-2"
                >
                <p class="text-gray-800 dark:text-gray-100 font-semibold">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">
                    {{ Auth::user()->role }}
                </p>
                <a href="{{ route('profile.edit') }}" 
                   class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                    Edit Profil
                </a>
            </div>

            {{-- Daftar Menu Sidebar --}}
            <div class="p-4 overflow-y-auto h-[calc(100%-15rem)]">
                <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">Menu</h2>

                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}">
                            <i class="fas fa-home w-5"></i>
                            <span class="ml-2">Dashboard</span>
                        </a>
                    </li>

                    {{-- ADMIN --}}
                    @if(Auth::user()->role === 'admin')
                        <li><a href="{{ route('products.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('products.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}"><i class="fas fa-box-open w-5"></i><span class="ml-2">Produk</span></a></li>
                        <li><a href="{{ route('stock-transactions.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('stock-transactions.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}"><i class="fas fa-chart-bar w-5"></i><span class="ml-2">Stok</span></a></li>
                        <li><a href="{{ route('suppliers.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('suppliers.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}"><i class="fas fa-truck w-5"></i><span class="ml-2">Supplier</span></a></li>
                        <li><a href="{{ route('users.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('users.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}"><i class="fas fa-users w-5"></i><span class="ml-2">Pengguna</span></a></li>
                        <li><a href="{{ route('reports.stock') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('reports.*') ? 'bg-gray-100 dark:bg-gray-700 font-semibold' : '' }}"><i class="fas fa-file-alt w-5"></i><span class="ml-2">Laporan</span></a></li>
                    @endif

                    {{-- MANAGER --}}
                    @if(Auth::user()->role === 'manager')
                        <li><a href="{{ route('products.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-box-open w-5"></i><span class="ml-2">Produk</span></a></li>
                        <li><a href="{{ route('stock-transactions.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-chart-bar w-5"></i><span class="ml-2">Stok</span></a></li>
                        <li><a href="{{ route('suppliers.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-truck w-5"></i><span class="ml-2">Supplier</span></a></li>
                        <li><a href="{{ route('reports.stock') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-file-alt w-5"></i><span class="ml-2">Laporan</span></a></li>
                    @endif

                    {{-- STAFF --}}
                    @if(Auth::user()->role === 'staff')
                        <li><a href="{{ route('stock-transactions.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-clipboard-list w-5"></i><span class="ml-2">Stok Barang</span></a></li>
                        <li><a href="{{ route('gallery.index') }}" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700"><i class="fas fa-image w-5"></i><span class="ml-2">Galeri Produk</span></a></li>
                    @endif
                </ul>
            </div>

            {{-- Logout --}}
            <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-800 rounded">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span class="ml-2">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- ✅ KONTEN UTAMA --}}
        <div class="flex-1 flex flex-col">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow pt-16">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="px-4 sm:px-6 lg:px-8 py-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
