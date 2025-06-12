@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-blue-800 mb-6">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-10">
        <!-- Order Summary -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Ringkasan Pesanan</h2>

            <div class="space-y-4">
                @foreach($products as $item)
                <div class="flex items-center p-3 hover:bg-gray-100 transition-colors duration-200 rounded-md">
                    <div class="w-16 h-16 rounded overflow-hidden mr-4">
                        <img src="{{ $item['product']->image ?? '/default_product.png' }}"
                             alt="{{ $item['product']->name }}"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-sm font-medium text-gray-800">{{ $item['product']->name }}</h3>
                        <p class="text-xs text-gray-600">{{ $item['product']->category?->name ?? 'Uncategorized' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-700">{{ $item['quantity'] }} × Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                        <p class="text-sm font-semibold text-green-600">Rp {{ number_format($item['total_price'], 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="border-t border-gray-200 pt-4 mt-4">
                <div class="flex justify-between items-center text-lg font-semibold text-gray-900">
                    <span>Total Belanja</span>
                    <span class="text-xl text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div>
            <div class="bg-white p-6 rounded-lg shadow-md sticky top-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b border-gray-200 pb-2">Informasi Pengiriman & Pembayaran</h2>

                <form action="{{ route('checkout.process') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="total" value="{{ $total }}">

                    <div class="mb-4">
                        <label for="shipping_address" class="block text-gray-700 text-sm font-medium mb-2">Alamat Pengiriman</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  required>{{ Auth::user()->address ?? '' }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Metode Pembayaran</label>
                        <div class="space-y-2">
                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md transition-colors">
                                <input type="radio" name="payment_method" value="transfer"
                                       class="text-blue-600 focus:ring-blue-500 h-4 w-4"
                                       checked>
                                <span class="text-sm text-gray-800">Transfer Bank</span>
                            </label>
                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md transition-colors">
                                <input type="radio" name="payment_method" value="cod"
                                       class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                                <span class="text-sm text-gray-800">Cash on Delivery (COD)</span>
                            </label>
                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-md transition-colors">
                                <input type="radio" name="payment_method" value="credit_card"
                                       class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                                <span class="text-sm text-gray-800">Kartu Kredit</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 px-4 rounded-md hover:from-blue-700 hover:to-purple-700 transition-colors duration-200 text-sm font-medium">
                        Proses Pesanan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection