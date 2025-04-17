@extends('layouts.staff')

@section('title', 'Edit Produk')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Edit Produk</h2>
        <a href="{{ route('staff.products.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-md transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('staff.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Produk -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category_id" id="category_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                        <input type="number" name="price" id="price"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('price', $product->price) }}" min="0" required>
                    </div>
                    @error('price')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stock" id="stock"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('stock', $product->stock) }}" min="0" required>
                    @error('stock')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Gambar Produk -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mt-2">
                    <div>
                        @if ($product->image_url)
                            <img id="previewImage" src="{{ $product->image_url }}" alt="Current Image" class="w-32 h-32 object-cover rounded-md shadow-md">
                        @else
                            <img id="previewImage" src="https://via.placeholder.com/150" alt="Preview" class="w-32 h-32 object-cover rounded-md shadow-md">
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" name="image" id="image" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0 file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-2 text-xs text-gray-400">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                        @error('image')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="flex items-center space-x-2">
                <input type="checkbox" name="is_active" id="is_active"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="block text-sm font-medium text-gray-700">Produk Aktif</label>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="inline-flex justify-center items-center w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-lg font-bold rounded-md transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Preview Gambar Upload -->
<script>
    document.getElementById('image').addEventListener('change', function (event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('previewImage').src = URL.createObjectURL(file);
        }
    });
</script>
@endsection
