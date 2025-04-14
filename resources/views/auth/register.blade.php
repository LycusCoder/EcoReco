@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden">
        <div class="px-8 py-10">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <i class="fas fa-user-plus text-green-500 text-5xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h2>
                <p class="text-sm text-gray-500 mt-2">Isi data di bawah untuk membuat akun</p>
            </div>

            <!-- Form Register -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <div class="mt-1 relative">
                        <input id="name" name="name" type="text" required autofocus
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            placeholder="Nama Lengkap">
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1 relative">
                        <input id="email" name="email" type="email" required
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            placeholder="you@example.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <div class="mt-1 relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Tombol Register -->
                <div>
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 shadow-md">
                        <i class="fas fa-user-check"></i>
                        Daftar
                    </button>
                </div>
            </form>

            <!-- Sudah Punya Akun -->
            <div class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}"
                    class="font-semibold text-blue-600 hover:text-blue-800 transition duration-200">Login di sini</a>
            </div>
        </div>
    </div>
</div>
@endsection
