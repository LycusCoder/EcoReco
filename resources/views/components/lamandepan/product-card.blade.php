<div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 h-full flex flex-col group relative">
    <!-- Badge Diskont & Stok Habis -->
    <div class="absolute top-3 left-3 flex flex-col space-y-1.5 z-10">
        @if ($product->discount)
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">
                <i class="fas fa-bolt mr-1"></i> {{ $product->discount }}% OFF
            </div>
        @endif

        @if ($product->stock <= 0)
            <div class="bg-gray-700 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">
                <i class="fas fa-box-open mr-1"></i> Stok Habis
            </div>
        @endif
    </div>

    <!-- Gambar Produk -->
    <a href="{{ route('products.lihat', $product->slug) }}" class="relative pt-[75%] overflow-hidden block bg-gray-50">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
            class="absolute top-0 left-0 w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-300 ease-in-out"
            loading="lazy"
            onerror="this.src='https://via.placeholder.com/300x300?text=Produk+Tidak+Tersedia'">
    </a>

    <!-- Informasi Produk -->
    <div class="p-4 flex-grow flex flex-col">
        <!-- Kategori -->
        <p class="text-blue-600 text-xs font-medium mb-1">
            <i class="fas fa-tag mr-1"></i> {{ $product->category?->name ?? 'Tanpa Kategori' }}
        </p>

        <!-- Nama Produk -->
        <a href="{{ route('products.lihat', $product->slug) }}" class="hover:text-blue-600 transition-colors">
            <h3 class="font-semibold text-gray-900 text-sm md:text-base line-clamp-2 leading-snug mb-2">{{ $product->name }}</h3>
        </a>

        <!-- Harga -->
        <div class="mt-auto">
            @if ($product->discount)
                <div class="flex flex-col">
                    <span class="text-red-600 font-bold text-base md:text-lg">
                        Rp {{ number_format($product->price - ($product->price * $product->discount) / 100, 0, ',', '.') }}
                    </span>
                    <span class="text-gray-400 text-xs md:text-sm line-through">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>
            @else
                <span class="text-gray-900 font-bold text-base md:text-lg">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
            @endif

            <!-- Rating dan Tombol -->
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center">
                    <div class="flex text-yellow-400 text-xs mr-1">
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
                    <span class="text-gray-500 text-xs">({{ $product->ratings_count ?? 0 }})</span>
                </div>

                <button onclick="addToCart({{ $product->id }})"
                    class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center bg-blue-600 hover:bg-blue-700 rounded-full text-white transition-all duration-300 shadow-sm hover:shadow-md"
                    {{ $product->stock <= 0 ? 'disabled' : '' }}
                    title="Tambah ke Keranjang">
                    <i class="fas fa-cart-plus text-xs md:text-sm"></i>
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
