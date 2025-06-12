@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-200 pb-2">Keranjang Belanja</h1>

    @if(count($products) > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="divide-y divide-gray-100">
                @foreach($products as $item)
                <div class="p-4 flex flex-col md:flex-row items-center hover:bg-gray-50 transition-colors duration-200">
                    <div class="w-full md:w-1/4">
                        <img src="{{ $item['product']->image ?? '/default_product.png' }}"
                             alt="{{ $item['product']->name }}"
                             class="w-full h-32 object-cover rounded-lg transform hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="w-full md:w-2/4 px-4 mt-4 md:mt-0">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <a href="{{ route('products.lihat', $item['product']->slug) }}" class="hover:text-blue-600 transition-colors">
                                {{ $item['product']->name }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">{{ $item['product']->category?->name ?? 'Uncategorized' }}</p>
                    </div>
                    <div class="w-full md:w-1/4 mt-4 md:mt-0 flex flex-col md:flex-row items-center justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <form action="{{ route('cart.update') }}" method="POST" class="flex items-center bg-gray-100 rounded-lg p-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"
                                        class="w-8 h-8 text-gray-600 hover:text-gray-800 rounded-l flex items-center justify-center transition-colors">
                                    -
                                </button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                       class="w-12 h-8 border-0 text-center bg-transparent focus:outline-none">
                                <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"
                                        class="w-8 h-8 text-gray-600 hover:text-gray-800 rounded-r flex items-center justify-center transition-colors">
                                    +
                                </button>
                                <button type="submit" class="ml-2 text-blue-600 hover:text-blue-800 transition-colors">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </div>
                        <div class="text-lg font-semibold text-gray-800">
                            Rp {{ number_format($item['total_price'], 0, ',', '.') }}
                        </div>
                        <form action="{{ route('cart.remove') }}" method="POST" class="ml-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-between items-center bg-gray-50">
                <div class="text-xl font-bold text-gray-900">
                    Total: Rp {{ number_format($total, 0, ',', '.') }}
                </div>
                @auth
                    <a href="{{ route('checkout') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 px-6 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200">
                        Checkout
                    </a>
                @else
                    <button onclick="showLoginAlert()"
                            class="bg-gray-400 text-white py-2 px-6 rounded-lg hover:bg-gray-500 transition-colors cursor-not-allowed">
                        Login untuk Checkout
                    </button>
                @endauth
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md p-8 text-center max-w-md mx-auto">
            <i class="fas fa-shopping-cart text-5xl text-gray-400 mb-6"></i>
            <h2 class="text-xl font-semibold text-gray-700">Keranjang belanja Anda kosong</h2>
            <p class="text-gray-500 mt-2">Mulai belanja sekarang dan temukan produk menarik!</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 px-6 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200">
                Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function showLoginAlert() {
        Swal.fire({
            title: 'Login Required',
            text: 'Anda harus login terlebih dahulu untuk melanjutkan checkout',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Login',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#d1d5db'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    }
</script>
@endpush