@extends('layouts.app')

@section('content')
    <div class="mt-6 mb-6 px-4">
        <!-- Hero Banner -->
        @include('components.lamandepan.hero-banner')

        <!-- Search Bar -->
        <div class="relative mt-8 mb-8 px-4">
            <form action="{{ route('products.search') }}" method="GET">
                <div class="relative">
                    <input type="text" name="q" placeholder="Cari produk..."
                        class="w-full pl-12 pr-12 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm transition-all duration-200 hover:shadow-md"
                        value="{{ request('q') }}">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button type="submit"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 transition-colors duration-200">
                        <i class="fas fa-arrow-right text-sm"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Kategori Produk -->
        <div x-data="{ showModal: false }" class="mb-10 px-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-tags mr-2 text-blue-500"></i> Kategori Produk
                </h2>
                <a href="#" @click.prevent="showModal = true"
                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Lihat Semua <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </div>
            <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3">
                @foreach ($displayCategories as $category)
                    <a href="{{ route('products.by.category', $category->slug) }}"
                        class="group flex flex-col items-center p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-all border border-gray-100 hover:border-blue-200">
                        <div
                            class="w-10 h-10 mb-2 flex items-center justify-center bg-blue-50 rounded-full text-blue-600 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                            <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                                class="w-6 h-6 sm:w-8 sm:h-8 object-contain" />
                        </div>
                        <span
                            class="text-xs text-center font-medium text-gray-700 group-hover:text-blue-600 transition-colors">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach
            </div>
            @include('components.lamandepan.category-modal', ['allCategories' => $allCategories])
        </div>

        <!-- Produk Populer dengan Carousel -->
        <div class="mb-10 px-4">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-bolt mr-2 text-yellow-500"></i> Produk Populer
                </h2>
                <div class="flex space-x-2">
                    <button id="prevButton"
                        class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-sm text-gray-600 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button id="nextButton"
                        class="w-8 h-8 flex items-center justify-center bg-white rounded-full shadow-sm text-gray-600 hover:bg-gray-100 transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Inilah scrollable wrapper dengan ID -->
            <div id="carouselWrapper" class="overflow-x-auto scroll-smooth scrollbar-hide">
                <div id="productContainer" class="flex flex-nowrap space-x-4 px-1">
                    @foreach ($products as $product)
                        <div class="flex-shrink-0 w-[250px]">
                            @include('components.lamandepan.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Penawaran Khusus -->
        <div class="mb-10 px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-5">
                <i class="fas fa-percentage mr-2 text-red-500"></i> Penawaran Khusus
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="relative rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/assets/media/offer/offer1.jpg') }}" alt="Penawaran 1"
                        class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <div class="bg-red-500 text-xs font-bold px-2 py-1 rounded mb-2 inline-block">
                            <i class="fas fa-fire mr-1"></i> TERBATAS
                        </div>
                        <h3 class="text-xl font-bold mb-1">Diskon Hingga 50%</h3>
                        <p class="text-sm opacity-90">Segera dapatkan sebelum kehabisan!</p>
                    </div>
                </div>
                <div class="relative rounded-xl overflow-hidden">
                    <img src="{{ asset('storage/assets/media/offer/offer2.png') }}" alt="Penawaran 2"
                        class="w-full h-48 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 text-white">
                        <div class="bg-green-500 text-xs font-bold px-2 py-1 rounded mb-2 inline-block">
                            <i class="fas fa-truck mr-1"></i> GRATIS
                        </div>
                        <h3 class="text-xl font-bold mb-1">Gratis Ongkir</h3>
                        <p class="text-sm opacity-90">Untuk pembelian di atas Rp500.000</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekomendasi untuk Anda -->
        <div class="mb-10 px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-5">
                <i class="fas fa-star mr-2 text-yellow-400"></i> Rekomendasi untuk Anda
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                @foreach ($recommendedProducts as $product)
                    @include('components.lamandepan.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>

        <!-- Testimoni Pelanggan -->
        <div class="mb-6 px-4">
            @include('components.lamandepan.testimonial', ['testimonials' => $testimonials])
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const prevBtn = document.getElementById('prevButton');
            const nextBtn = document.getElementById('nextButton');
            const wrapper = document.getElementById('carouselWrapper');

            // Hitung lebar item + jarak antar (space-x-4 = 16px)
            const item = wrapper.querySelector('.flex-shrink-0');
            const gap = 16; // space-x-4
            const scrollAmount = item.offsetWidth + gap;

            prevBtn.addEventListener('click', () => {
                wrapper.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            });
            nextBtn.addEventListener('click', () => {
                wrapper.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endpush
