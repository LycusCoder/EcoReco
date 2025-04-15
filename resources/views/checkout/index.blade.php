@extends('layouts.app')

@section('content')
<div class="container py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Order Summary -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>

                <div class="divide-y divide-gray-200">
                    @foreach($products as $item)
                    <div class="py-4 flex items-center">
                        <div class="w-20 h-20 rounded overflow-hidden mr-4">
                            <img src="{{ $item['product']->image ?? '/assets/default-product.jpg' }}"
                                 alt="{{ $item['product']->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-gray-800 font-medium">{{ $item['product']->name }}</h3>
                            <p class="text-gray-500 text-sm">{{ $item['product']->category?->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-800">{{ $item['quantity'] }} × Rp {{ number_format($item['product']->price, 0, ',', '.') }}</p>
                            <p class="font-semibold">Rp {{ number_format($item['total_price'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-xl font-semibold mb-4">Informasi Pengiriman & Pembayaran</h2>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="total" value="{{ $total }}">

                    <div class="mb-4">
                        <label for="shipping_address" class="block text-gray-700 mb-2">Alamat Pengiriman</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  required>{{ Auth::user()->address ?? '' }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 mb-2">Metode Pembayaran</label>

                        <div class="space-y-2">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="payment_method" value="transfer"
                                       class="text-blue-600 focus:ring-blue-500" checked>
                                <span>Transfer Bank</span>
                            </label>

                            <label class="flex items-center space-x-2">
                                <input type="radio" name="payment_method" value="cod"
                                       class="text-blue-600 focus:ring-blue-500">
                                <span>Cash on Delivery (COD)</span>
                            </label>

                            <label class="flex items-center space-x-2">
                                <input type="radio" name="payment_method" value="credit_card"
                                       class="text-blue-600 focus:ring-blue-500">
                                <span>Kartu Kredit</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Proses Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
