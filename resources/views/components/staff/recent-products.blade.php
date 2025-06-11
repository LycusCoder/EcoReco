<div class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800 flex items-center">
            <i class="fas fa-boxes mr-2 text-purple-500"></i> Produk Terbaru
        </h3>
        <a href="{{ route('staff.products.index') }}" class="text-sm text-blue-500 hover:text-blue-700 font-medium">Lihat Semua</a>
    </div>
    <div class="divide-y divide-gray-200 flex-grow">
        @forelse ($products as $product)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($product->name, 25) }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $product->category->name }}</p>
                    </div>
                    <span class="text-sm font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock }} stok
                    </span>
                </div>
            </div>
        @empty
             <div class="p-6 text-center text-gray-500">
                <i class="fas fa-box-open text-2xl mb-2"></i>
                <p>Belum ada produk.</p>
            </div>
        @endforelse
    </div>
</div>