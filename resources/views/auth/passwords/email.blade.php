@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-blue-50 to-indigo-100 px-4">
        <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Reset Password</h2>

            @if (session('status'))
                <div class="bg-green-100 text-green-700 text-sm p-3 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" required autofocus
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Kirim Link Reset Password
                </button>
            </form>

            <div class="text-sm text-center mt-6 text-gray-600">
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Kembali ke Login</a>
            </div>
        </div>
    </div>
@endsection
