@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Product Image -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ $product->image ?? '/assets/default-product.jpg' }}" alt="{{ $product->name }}"
                 class="w-full h-auto object-cover">
        </div>

        <!-- Product Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            @if ($product->discount)
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                    {{ $product->discount }}% OFF
                </span>
            @endif

            <h1 class="text-2xl font-bold text-gray-800 mt-4">{{ $product->name }}</h1>
            <p class="text-gray-500 text-sm mt-1">
                <i class="fas fa-tag mr-1"></i> {{ $product->category?->name ?? 'Uncategorized' }}
            </p>

            <div class="mt-4">
                @if ($product->discount)
                    <div class="flex items-center">
                        <span class="text-red-500 font-bold text-2xl">
                            Rp {{ number_format($product->price - ($product->price * $product->discount) / 100, 0, ',', '.') }}
                        </span>
                        <span class="text-gray-400 text-lg line-through ml-2">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>
                @else
                    <span class="text-blue-600 font-bold text-2xl">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-800">Deskripsi Produk</h2>
                <p class="text-gray-600 mt-2">{{ $product->description }}</p>
            </div>

            <div class="mt-6 flex items-center">
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
                <span class="text-gray-500 text-sm ml-1">({{ $product->ratings()->count() }} ulasan)</span>
            </div>

            <div class="mt-8">
                <button onclick="addToCart({{ $product->id }})"
                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-12">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Produk Terkait</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($relatedProducts as $relatedProduct)
                @include('components.lamandepan.product-card', ['product' => $relatedProduct])
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function addToCart(productId) {
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Update counter keranjang
                const cartCount = document.getElementById('cart-count');
                if(cartCount) {
                    cartCount.textContent = data.cart_count;
                }

                // Notifikasi sukses
                alert('Produk berhasil ditambahkan ke keranjang!');
            } else {
                alert('Gagal menambahkan produk ke keranjang: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menambahkan ke keranjang');
        });
    }
</script>
@endpush
