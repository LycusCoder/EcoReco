<!-- Kartu Informasi Pribadi -->
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h2>
        <button id="toggle-edit-profile" class="text-blue-600 hover:text-blue-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </button>
    </div>

    <!-- Form Edit Informasi Pribadi -->
    <form method="POST" action="{{ route('profile.update') }}" id="edit-profile-form" class="hidden space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor
                Telepon</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea id="address" name="address" rows="2"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('address', $user->address) }}</textarea>
            @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Simpan Perubahan
        </button>
    </form>

    <!-- Tampilan Informasi Pribadi -->
    <div id="view-profile" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Nama Lengkap</p>
                <p class="font-medium">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nomor Telepon</p>
                <p class="font-medium">{{ $user->phone ?? '-' }}</p>
            </div>
        </div>

        <div>
            <p class="text-sm text-gray-500">Email</p>
            <p class="font-medium">{{ $user->email }}</p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Alamat</p>
            <p class="font-medium">{{ $user->address ?? '-' }}</p>
        </div>
    </div>
</div>
