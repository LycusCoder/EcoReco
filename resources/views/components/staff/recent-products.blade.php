{{-- resources/views/components/staff/recent-products.blade.php --}}
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800 flex items-center">
            <i class="fas fa-boxes mr-2 text-purple-500"></i> Produk Terbaru
        </h3>
        <a href="{{ route('staff.products.index') }}" class="text-sm text-blue-500 hover:text-blue-700">Lihat Semua</a>
    </div>
    <div class="divide-y divide-gray-200">
        @foreach ($products as $product)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                        <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                    </div>
                    <span class="text-sm font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock }} stok
                    </span>
                </div>
                <p class="text-xs text-gray-400 mt-2">Ditambahkan {{ $product->created_at->diffForHumans() }}</p>
            </div>
        @endforeach
    </div>
</div>
