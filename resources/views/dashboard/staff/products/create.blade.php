@extends('layouts.staff')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1/dist/cleave.min.js"></script>
    <script>
        // Format harga dengan pemisah ribuan
        new Cleave('input[name="price"]', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    </script>

    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-8 flex items-center gap-2">
            <i class="fas fa-plus-circle text-green-500"></i>
            Tambah Produk Baru
        </h1>

        <form action="{{ route('staff.products.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-lg shadow-md p-6">
            @csrf

            <!-- Product Details -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                    <i class="fas fa-box-open text-indigo-500"></i>
                    Detail Produk
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-gray-700">
                            <i class="fas fa-tag mr-2 text-sm"></i> Nama Produk
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            required>
                        @error('name')
                            <p class="mt-1 text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700">
                            <i class="fas fa-list-ul mr-2 text-sm"></i> Kategori
                        </label>
                        <select name="category_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                    <i class="fas fa-money-bill-alt text-yellow-500"></i>
                    Harga & Stok
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-gray-700">
                            <i class="fas fa-dollar-sign mr-2 text-sm"></i> Harga (Rp)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="text" name="price" value="{{ old('price') }}"
                                class="w-full px-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                min="0" required>
                        </div>
                        @error('price')
                            <p class="mt-1 text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-gray-700">
                            <i class="fas fa-boxes mr-2 text-sm"></i> Stok
                        </label>
                        <input type="number" name="stock" value="{{ old('stock') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            min="0" required>
                        @error('stock')
                            <p class="mt-1 text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                    <i class="fas fa-align-left text-teal-500"></i>
                    Deskripsi
                </h2>
                <textarea name="description"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar Produk -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                    <i class="fas fa-image text-pink-500"></i>
                    Gambar Produk
                </h2>
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <input type="file" id="image" name="image" class="hidden" accept="image/*">
                    <div>
                        <img id="image-preview" src="{{ asset('default_product.png') }}" alt="Preview"
                            class="w-32 h-32 object-cover rounded-lg border">
                    </div>
                    <div>
                        <button type="button" id="upload-btn"
                            class="bg-gray-200 hover:bg-gray-300 px-6 py-3 rounded-lg flex items-center gap-2">
                            <i class="fas fa-upload"></i> Pilih Gambar
                        </button>
                    </div>
                </div>
                @error('image')
                    <p class="mt-1 text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Simpan -->
            <div class="mt-8">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-indigo-600 hover:to-blue-600 text-white px-6 py-3 rounded-lg transition duration-300">
                    <i class="fas fa-save mr-2"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>

    <script>
        const uploadBtn = document.getElementById('upload-btn');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');

        uploadBtn.addEventListener('click', function() {
            imageInput.click();
        });

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
