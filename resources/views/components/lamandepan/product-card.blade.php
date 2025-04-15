<div
    class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow h-full flex flex-col group relative">
    <!-- Badge Diskont & Stok Habis -->
    <div class="absolute top-3 left-3 flex flex-col space-y-1 z-10">
        @if ($product->discount)
            <div class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                <i class="fas fa-tag mr-1"></i> {{ $product->discount }}% OFF
            </div>
        @endif

        @if ($product->stock <= 0)
            <div class="bg-gray-600 text-white text-xs font-bold px-2 py-1 rounded">
                <i class="fas fa-times-circle mr-1"></i> Stok Habis
            </div>
        @endif
    </div>

    @php
        use Illuminate\Support\Str;

        $imageUrl = '/assets/default-product.jpg';
        if ($product->image) {
            $imageUrl = Str::startsWith($product->image, ['http://', 'https://'])
                ? $product->image
                : asset('storage/' . $product->image);
        }
    @endphp

    <!-- Gambar Produk -->
    <a href="{{ route('products.show', $product->slug) }}" class="relative pt-[70%] overflow-hidden block">
        <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
            class="absolute top-0 left-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            loading="lazy">
    </a>


    <!-- Informasi Produk -->
    <div class="p-4 flex-grow flex flex-col">
        <!-- Nama dan Kategori -->
        <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600 transition-colors">
            <h3 class="font-semibold text-gray-800 text-lg mb-1 line-clamp-2">{{ $product->name }}</h3>
        </a>
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
                    <span class="text-gray-500 text-xs ml-1">({{ $product->ratings_count ?? 0 }})</span>
                </div>

                <button onclick="addToCart({{ $product->id }})"
                    class="w-8 h-8 flex items-center justify-center bg-blue-50 rounded-full text-blue-600 hover:bg-blue-100 transition-colors"
                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    <i class="fas fa-shopping-cart text-sm"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function addToCart(productId) {
            @auth
            fetch('{{ route('cart.add') }}', {
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
                    if (data.success) {
                        // Update counter keranjang
                        updateCartCount(data.cart_count);

                        // Notifikasi sukses dengan SweetAlert atau Toast
                        showToast('success', 'Produk berhasil ditambahkan ke keranjang!');
                    } else {
                        showToast('error', data.message || 'Gagal menambahkan produk');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('error', 'Terjadi kesalahan saat menambahkan ke keranjang');
                });
        @else
            // Redirect ke login jika belum login
            window.location.href = '{{ route('login') }}';
        @endauth
        }

        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(el => {
                el.textContent = count;
            });
        }

        function showToast(type, message) {
            // Implementasi toast notification
            // Anda bisa menggunakan library seperti SweetAlert atau Toastify
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }
    </script>
@endpush
