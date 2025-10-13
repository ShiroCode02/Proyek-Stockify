<x-guest-layout>
    <!-- Logo dan Judul -->
    <div class="flex flex-col items-center mb-5">
        <img src="{{ asset('images/stockify-logo.png') }}" alt="Stockify Logo" class="h-14 mb-1">
        <h1 class="text-2xl font-bold text-white tracking-tight leading-tight">Stockify</h1>
        <p class="text-sm text-gray-400 -mt-0.5">Inventory Management System</p>
    </div>

    <!-- Form Card -->
    <div class="w-full bg-gray-900 border border-gray-700 rounded-xl shadow-md p-6">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email"
                    class="block mt-1 w-full border-gray-700 bg-gray-800 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password"
                    class="block mt-1 w-full border-gray-700 bg-gray-800 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mt-4">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-600 text-indigo-600 focus:ring-indigo-500 bg-gray-800">
                <label for="remember_me" class="ml-2 text-sm text-gray-300">
                    {{ __('Remember me') }}
                </label>
            </div>

            <!-- Tombol -->
            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-400 hover:text-gray-200"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-md transition">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center mt-6 text-xs text-gray-500">
            &copy; {{ date('Y') }} <strong>Stockify</strong> — All Rights Reserved.
        </div>
    </div>
</x-guest-layout>
