@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Search and Filter Section -->
            <div
                class="bg-white rounded-xl shadow-md p-6 mb-8 transition-all duration-300 ease-in-out transform hover:shadow-lg">
                <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Temukan Produk Terbaik
                </h1>

                <form id="filterForm" method="GET" class="space-y-4 md:space-y-0 md:grid md:grid-cols-5 md:gap-4">

                    <!-- Live Search -->
                    <div class="transition-transform duration-200 hover:scale-105">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                        <input type="text" id="search" name="q" value="{{ request('q') }}"
                            placeholder="Cari berdasarkan nama..."
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition">
                    </div>

                    <!-- Category Filter -->
                    <div class="transition-transform duration-200 hover:scale-105">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select id="category" name="category"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sorting -->
                    <div class="transition-transform duration-200 hover:scale-105">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select id="sort" name="sort"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition">
                            <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Default</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga Terendah
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga
                                Tertinggi</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi
                            </option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        </select>
                    </div>

                    <!-- AI Recommendation Button -->
                    <div class="flex items-end transition-transform duration-200 hover:scale-105">
                        <a href="?recommended=true&q={{ request('q') }}&category={{ request('category') }}&sort={{ request('sort') }}"
                            class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-all duration-200 ease-in-out flex items-center justify-center group">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2 transition-transform group-hover:rotate-12" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                    clip-rule="evenodd" />
                            </svg>
                            Rekomendasi AI
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-end transition-transform duration-200 hover:scale-105">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- JavaScript untuk auto-submit form -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('search');
                    const categorySelect = document.getElementById('category');
                    const sortSelect = document.getElementById('sort');

                    function submitForm() {
                        const form = document.getElementById('filterForm');
                        const formData = new FormData(form);
                        const params = new URLSearchParams(formData).toString();
                        window.location.href = '?' + params;
                    }

                    // Event listener untuk live search & dropdown
                    searchInput.addEventListener('input', debounce(submitForm, 500));
                    categorySelect.addEventListener('change', submitForm);
                    sortSelect.addEventListener('change', submitForm);
                });

                // Debounce function untuk menunda pencarian
                function debounce(func, delay) {
                    let timer;
                    return function(...args) {
                        clearTimeout(timer);
                        timer = setTimeout(() => func.apply(this, args), delay);
                    };
                }
            </script>

            <!-- Results Section -->
            @if ($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <!-- Product Image -->
                                <div class="relative pb-[75%] overflow-hidden">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                        class="absolute h-full w-full object-cover hover:scale-105 transition duration-300">
                                    <!-- Stock Badge -->
                                    @if ($product->stock <= 0)
                                        <span
                                            class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            Habis
                                        </span>
                                    @elseif($product->stock < 10)
                                        <span
                                            class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            Hampir Habis
                                        </span>
                                    @endif
                                </div>
                                <!-- Product Details -->
                                <div class="p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-semibold text-lg text-gray-800 line-clamp-1">
                                                {{ $product->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                                        </div>
                                        @if ($product->is_active)
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">Aktif</span>
                                        @else
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full">Nonaktif</span>
                                        @endif
                                    </div>

                                    <!-- Rating -->
                                    <div class="flex items-center mt-2">
                                        <div class="flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($product->average_rating))
                                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @elseif($i == ceil($product->average_rating) && $product->average_rating - floor($product->average_rating) >= 0.5)
                                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-500 ml-1">({{ $product->ratings_count }})</span>
                                    </div>

                                    <!-- Price -->
                                    <div class="mt-3 flex items-center justify-between">
                                        <div>
                                            <span class="text-lg font-bold text-indigo-600">Rp
                                                {{ number_format($product->price, 0, ',', '.') }}</span>
                                            @if ($product->stock > 0)
                                                <span class="text-xs text-green-600 block">Stok:
                                                    {{ $product->stock }}</span>
                                            @endif
                                        </div>
                                        <button
                                            class="p-2 rounded-full bg-indigo-100 text-indigo-600 hover:bg-indigo-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Result Info -->
                <div class="mt-6 text-sm text-gray-600 dark:text-gray-300">
                    Menampilkan
                    <span class="font-medium">{{ $products->firstItem() }}</span>
                    hingga
                    <span class="font-medium">{{ $products->lastItem() }}</span>
                    dari
                    <span class="font-bold">{{ number_format($products->total()) }}</span> hasil
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center items-center space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <span class="px-4 py-2 rounded-full bg-gray-200 text-gray-500 cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" rel="prev"
                            class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 transition">Sebelumnya</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            <span
                                class="px-4 py-2 rounded-full bg-blue-600 text-white font-medium">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="px-4 py-2 rounded-full bg-gray-100 text-gray-700 hover:bg-blue-100 transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" rel="next"
                            class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 transition">Selanjutnya</a>
                    @else
                        <span
                            class="px-4 py-2 rounded-full bg-gray-200 text-gray-500 cursor-not-allowed">Selanjutnya</span>
                    @endif
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Produk tidak ditemukan</h3>
                    <p class="mt-1 text-sm text-gray-500">Coba gunakan filter yang berbeda atau kata kunci lain.</p>
                    <div class="mt-6">
                        <a href="{{ url()->current() }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Reset Filter
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
