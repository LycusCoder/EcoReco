@extends('layouts.app')
@if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
        <div class="flex items-center">
            <div class="py-1">
                <svg class="w-6 h-6 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="font-bold">Sukses!</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif
@section('content')
    <div class="container py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                        <a href="{{ route('products.by.category', $product->category->slug) }}"
                            class="ml-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                            {{ $product->category->name }}
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                        <span class="ml-2 text-sm font-medium text-gray-500">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Image Gallery -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative pt-[70%] overflow-hidden">
                    @php
                        use Illuminate\Support\Str;

                        // Default image jika kondisi terpenuhi
                        $imageUrl = asset('/default_product.png');

                        if ($product->image) {
                            // Cek apakah URL dimulai dengan https://example
                            if (Str::startsWith($product->image, 'https://example')) {
                                $imageUrl = asset('/default_product.png');
                            }
                            // Cek apakah URL dimulai dengan http:// atau https:// (selain https://example)
                            elseif (Str::startsWith($product->image, ['http://', 'https://'])) {
                                $imageUrl = $product->image;
                            }
                            // Jika tidak dimulai dengan http:// atau https://, asumsikan ini adalah path relatif ke storage
                            else {
                                $imageUrl = asset('storage/' . $product->image);
                            }
                        }
                    @endphp
                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                        class="absolute top-0 left-0 w-full h-full object-cover" id="mainProductImage">
                </div>
            </div>
            <!-- Product Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                @if ($product->discount || $product->stock <= 0)
                    <div class="flex space-x-2 mb-4">
                        @if ($product->discount)
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                {{ $product->discount }}% OFF
                            </span>
                        @endif
                        @if ($product->stock <= 0)
                            <span class="bg-gray-600 text-white text-xs font-bold px-2 py-1 rounded">
                                <i class="fas fa-times-circle mr-1"></i> Stok Habis
                            </span>
                        @endif
                    </div>
                @endif
                <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>
                <p class="text-gray-500 text-sm mt-1">
                    <i class="fas fa-tag mr-1"></i> {{ $product->category?->name ?? 'Uncategorized' }}
                </p>
                <!-- Rating -->
                <div class="flex items-center mt-4">
                    <div class="flex text-yellow-400 text-sm">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($product->rating))
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $product->rating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-gray-500 text-sm ml-1">({{ $product->ratings_count }} rating)</span>
                </div>
                <!-- Harga -->
                <div class="mt-4">
                    @if ($product->discount)
                        <div class="flex items-center">
                            <span class="text-red-500 font-bold text-2xl">
                                Rp
                                {{ number_format($product->price - ($product->price * $product->discount) / 100, 0, ',', '.') }}
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
                    @if ($product->stock > 0)
                        <div class="text-green-600 text-sm mt-1">
                            <i class="fas fa-check-circle mr-1"></i> Stok tersedia: {{ $product->stock }}
                        </div>
                    @endif
                </div>
                <!-- Deskripsi -->
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-800">Deskripsi Produk</h2>
                    <div class="text-gray-600 mt-2 prose max-w-none">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
                <!-- Tombol Aksi -->
                <div class="mt-8 space-y-3">
                    @if ($product->stock > 0)
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center border rounded-lg overflow-hidden">
                                <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200" onclick="updateQuantity(-1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantity" value="1" min="1"
                                    max="{{ $product->stock }}" class="w-12 text-center border-0 focus:ring-0">
                                <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200" onclick="updateQuantity(1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <span class="text-sm text-gray-500">Maks: {{ $product->stock }} pcs</span>
                        </div>
                        <button onclick="addToCart({{ $product->id }})"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                            <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                        </button>
                    @else
                        <button disabled class="w-full bg-gray-400 text-white py-3 px-4 rounded-lg cursor-not-allowed">
                            <i class="fas fa-times-circle mr-2"></i> Stok Habis
                        </button>
                    @endif
                    <button
                        class="w-full border border-blue-600 text-blue-600 py-3 px-4 rounded-lg hover:bg-blue-50 transition-colors flex items-center justify-center">
                        <i class="far fa-heart mr-2"></i> Tambah ke Wishlist
                    </button>
                </div>
            </div>
        </div>
        <!-- Product Details Tabs -->
        <div class="mt-12 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button data-tab="details"
                        class="tab-button active py-4 px-6 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                        Detail Produk
                    </button>
                    <button data-tab="specs"
                        class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Spesifikasi
                    </button>
                    <button data-tab="reviews"
                        class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Ulasan ({{ $product->ratings_count ?? 0 }})
                    </button>
                </nav>
            </div>
            <div class="p-6 tab-content active" id="tab-details-content">
                <h3 class="text-lg font-semibold mb-4">Informasi Detail</h3>
                <div class="prose max-w-none">
                    {!! nl2br(e($product->details ?? 'Tidak ada informasi tambahan')) !!}
                </div>
            </div>
            <div class="p-6 tab-content hidden" id="tab-specs-content">
                <h3 class="text-lg font-semibold mb-4">Spesifikasi Produk</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-full text-center py-4">
                        <p class="text-gray-500 italic">Tidak ada spesifikasi untuk produk ini.</p>
                    </div>
                </div>
            </div>
            <div class="p-6 tab-content hidden" id="tab-reviews-content">
                <h3 class="text-lg font-semibold mb-4" id="reviews">Ulasan Pelanggan</h3>
                @if ($product->ratings->count() > 0)
                    @foreach ($product->ratings as $rating)
                        <div class="border-b border-gray-200 pb-4 mb-4">
                            <div class="flex items-center mb-2">
                                <div class="flex text-yellow-400 text-sm mr-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-gray-500 text-sm">{{ $rating->user->name }}</span>
                                <span class="text-gray-400 text-sm mx-2">•</span>
                                <span class="text-gray-500 text-sm">{{ $rating->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-600">{{ $rating->comment }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
                @endif
                @auth
                    <div class="mt-8">
                        <h4 class="font-medium mb-2">Beri Rating</h4>
                        <form action="{{ route('products.rate', $product->id) }}" method="POST">
                            @csrf
                            <div class="flex items-center mb-4">
                                <span class="mr-2 text-gray-700">Rating:</span>
                                <div class="rating-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="far fa-star text-yellow-400 text-xl cursor-pointer"
                                            data-rating="{{ $i }}" onmouseover="highlightStars(this)"
                                            onclick="setRating(this)"></i>
                                    @endfor
                                    <input type="hidden" name="rating" id="rating-value" value="0">
                                </div>
                            </div>
                            <button type="submit"
                                class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Kirim
                                Rating</button>
                        </form>
                    </div>
                @else
                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a> untuk memberikan
                        rating.
                    </div>
                @endauth
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Produk Terkait</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach ($relatedProducts as $relatedProduct)
                        @include('components.lamandepan.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Rekomendasi Produk -->
        @if ($recommendedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Rekomendasi Untuk Anda</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach ($recommendedProducts as $product)
                        @include('components.lamandepan.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .prose {
            line-height: 1.6;
        }

        .prose p {
            margin-bottom: 1em;
        }

        .tab-button.active {
            color: #3b82f6;
            border-color: #3b82f6;
        }

        .rating-stars i.active {
            font-weight: 900;
            /* Solid star */
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Tab functionality
        document.querySelectorAll('.rating-stars i').forEach(star => {
            star.addEventListener('mouseover', function() {
                highlightStars(this);
            });

            star.addEventListener('click', function() {
                setRating(this);
            });
        });

        // Change main product image
        function changeMainImage(src) {
            document.getElementById('mainProductImage').src = src;
        }

        // Quantity control
        function updateQuantity(change) {
            const input = document.getElementById('quantity');
            let newValue = parseInt(input.value) + change;
            const max = parseInt(input.max);
            const min = parseInt(input.min);
            if (newValue > max) newValue = max;
            if (newValue < min) newValue = min;
            input.value = newValue;
        }

        // Rating stars
        function highlightStars(element) {
            const rating = parseInt(element.getAttribute('data-rating'));
            const stars = element.parentElement.querySelectorAll('i');

            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('fas', 'active');
                    star.classList.remove('far');
                } else {
                    star.classList.add('far');
                    star.classList.remove('fas', 'active');
                }
            });
        }

        function setRating(element) {
            const rating = parseInt(element.getAttribute('data-rating'));
            document.getElementById('rating-value').value = rating;

            // Tetapkan visual bintang yang dipilih
            const stars = element.parentElement.querySelectorAll('i');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('fas', 'active');
                    star.classList.remove('far');
                } else {
                    star.classList.add('far');
                    star.classList.remove('fas', 'active');
                }
            });
        }

        // Add to cart function
        function addToCart(productId) {
            const quantity = document.getElementById('quantity') ? parseInt(document.getElementById('quantity').value) : 1;
            @auth
            fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCount(data.cart_count);
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
            if (typeof Swal !== 'undefined') {
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
            } else {
                alert(message); // Fallback jika SweetAlert tidak tersedia
            }
        }
        @auth
        @if ($userRating = $product->ratings->where('user_id', auth()->id())->first())
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('rating-value').value = {{ $userRating->rating }};
                highlightStars(document.querySelector(`.rating-stars i[data-rating="{{ $userRating->rating }}"]`));
            });
        @endif
        @endauth
    </script>
@endpush
