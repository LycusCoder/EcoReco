@extends('layouts.app')

@section('content')
    <div class="mt-6 mb-6 px-4">
        <!-- Hero Banner -->
        @include('components.lamandepan.hero-banner')

        <!-- Search Bar dengan Icon -->
        <div class="relative mb-8">
            <input v-model="searchQuery" placeholder="Cari produk..."
                class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>

        <!-- Kategori dengan Ikon Font Awesome -->
        <div x-data="{ showModal: false }" class="mb-10">
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
                    <div
                        class="group flex flex-col items-center p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-all border border-gray-100 hover:border-blue-200 cursor-pointer">
                        <div
                            class="w-10 h-10 mb-2 flex items-center justify-center bg-blue-50 rounded-full text-blue-600 group-hover:bg-blue-100 group-hover:text-blue-700 transition-colors">
                            <img src="storage/{{ $category->icon }}" alt="icon"
                                class="w-6 h-6 sm:w-8 sm:h-8 mb-1 object-contain" />
                        </div>
                        <span
                            class="text-xs text-center font-medium text-gray-700 group-hover:text-blue-600 transition-colors">{{ $category->name }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Include Modal Component -->
            @include('components.lamandepan.category-modal', ['allCategories' => $allCategories])
        </div>


        <!-- Produk Populer dengan Ikon -->
        <div class="mb-10 relative">
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

            <div class="relative overflow-hidden">
                <div class="overflow-x-auto pb-5 scrollbar-hide">
                    <div id="productContainer" class="flex space-x-5 transition-transform duration-300 ease-in-out">
                        @foreach ($products as $product)
                            <div class="min-w-[280px] sm:min-w-[300px] lg:min-w-[350px] flex-shrink-0">
                                @include('components.lamandepan.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Penawaran Khusus dengan Ikon -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-5">
                <i class="fas fa-percentage mr-2 text-red-500"></i> Penawaran Khusus
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="relative rounded-xl overflow-hidden">
                    <img src="storage/assets/media/offer/offer1.jpg" alt="Penawaran 1" class="w-full h-48 object-cover">
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
                    <img src="storage/assets/media/offer/offer2.png" alt="Penawaran 2" class="w-full h-48 object-cover">
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
        <div class="mb-10">
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
        <div class="mb-6">
            @include('components.lamandepan.testimonial', ['testimonials' => $testimonials])
        </div>
    </div>
@endsection
