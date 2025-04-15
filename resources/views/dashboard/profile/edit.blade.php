@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{ activeTab: 'personal-info' }">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Pengaturan Profil</h1>

        @if (session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded mb-6 shadow-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tab Bar -->
        <div class="mb-8">
            <ul class="flex space-x-4 overflow-x-auto whitespace-nowrap pb-2 border-b border-gray-200">
                <li>
                    <button @click="activeTab = 'personal-info'"
                        :class="activeTab === 'personal-info' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700'"
                        class="text-sm font-medium py-2 flex items-center focus:outline-none">
                        <i class="fas fa-user mr-2"></i> Informasi Pribadi
                    </button>
                </li>
                <li>
                    <button @click="activeTab = 'change-password'"
                        :class="activeTab === 'change-password' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-700'"
                        class="text-sm font-medium py-2 flex items-center focus:outline-none">
                        <i class="fas fa-lock mr-2"></i> Ubah Sandi
                    </button>
                </li>
            </ul>
        </div>

        <!-- Personal Information Card -->
        <div x-show="activeTab === 'personal-info'" class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea id="address" name="address" rows="2"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300">
                        Perbarui Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Card -->
        <div x-show="activeTab === 'change-password'" class="bg-white rounded-lg shadow-md p-6" x-cloak>
            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Sandi Saat Ini</label>
                        <input type="password" id="current_password" name="current_password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Sandi Baru</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Sandi Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300">
                        Ubah Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
