<div
    class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow h-full flex flex-col group">
    <!-- Badge Diskont -->
    @if ($product->discount)
        <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded z-10">
            <i class="fas fa-tag mr-1"></i> {{ $product->discount }}% OFF
        </div>
    @endif

    <!-- Gambar Produk -->
    <div class="relative pt-[70%] overflow-hidden">
        <img src="{{ $product->image ?? '/assets/default-product.jpg' }}" alt="{{ $product->name }}"
            class="absolute top-0 left-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    </div>

    <!-- Informasi Produk -->
    <div class="p-4 flex-grow flex flex-col">
        <!-- Nama dan Kategori -->
        <h3 class="font-semibold text-gray-800 text-lg mb-1 line-clamp-2">{{ $product->name }}</h3>
        <p class="text-gray-500 text-sm mb-3">
            <i class="fas fa-tag mr-1 text-gray-400"></i> {{ $product->category?->name ?? 'Uncategorized' }}
        </p>

        <!-- Harga -->
        <div class="mt-auto">
            @if ($product->discount)
                <div class="flex items-center">
                    <span class="text-red-500 font-bold text-lg">
                        Rp
                        {{ number_format($product->price - ($product->price * $product->discount) / 100, 0, ',', '.') }}
                    </span>
                    <span class="text-gray-400 text-sm line-through ml-2">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>
            @else
                <span class="text-blue-600 font-bold text-lg">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
            @endif

            <!-- Rating dan Tombol -->
            <div class="flex justify-between items-center mt-3">
                <div class="flex items-center">
                    <div class="flex text-yellow-400 text-sm">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($product->average_rating))
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $product->average_rating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-gray-500 text-xs ml-1">({{ $product->ratings()->count() }})</span>
                </div>

                <button
                    class="w-8 h-8 flex items-center justify-center bg-blue-50 rounded-full text-blue-600 hover:bg-blue-100 transition-colors">
                    <i class="fas fa-shopping-cart text-sm"></i>
                </button>
            </div>
        </div>
    </div>
</div>
