@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="px-8 py-10">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <i class="fas fa-user-circle text-blue-500 text-5xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali</h2>
                <p class="text-sm text-gray-500 mt-2">Masuk untuk melanjutkan ke akunmu</p>
            </div>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 relative">
                        <input type="email" name="email" id="email"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            placeholder="you@example.com"
                            value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1 relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            placeholder="••••••••" required>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Login -->
                <div>
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 shadow-md">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk
                    </button>
                </div>
            </form>

            <!-- Lupa Password -->
            <div class="mt-6 text-center">
                <a href="{{ route('password.request') }}"
                    class="text-sm text-blue-500 hover:text-blue-700 transition duration-200">Lupa Password?</a>
            </div>

            <!-- Register -->
            <div class="mt-4 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="font-semibold text-blue-600 hover:text-blue-800 transition duration-200">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection
