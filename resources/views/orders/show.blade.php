@extends('layouts.app')

@section('content')
<div class="container py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan #{{ $order->id }}</h1>
        <span class="px-3 py-1 rounded-full text-sm font-medium
            @if($order->status == 'completed') bg-green-100 text-green-800
            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
            @else bg-yellow-100 text-yellow-800 @endif">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Produk Dipesan -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0h2v2H7v-2z" />
                    </svg>
                    Produk Dipesan
                </h2>

                <!-- Daftar Produk -->
                <div class="divide-y divide-gray-200">
                    @foreach ($order->orderItems as $item)
                    <div class="py-4 flex items-center">
                        <div class="w-20 h-20 rounded overflow-hidden mr-4">
                            <img src="{{ $item->product->image ?? '/default_product.png' }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-gray-800 font-medium">{{ $item->product->name }}</h3>
                            <p class="text-gray-500 text-sm">{{ $item->product->category?->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-800">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            <p class="font-semibold">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Total Harga -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Pesanan -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4 space-y-4">
                <h2 class="text-xl font-semibold flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Informasi Pesanan
                </h2>

                <!-- Tanggal Pesanan -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Tanggal Pesanan</h3>
                    <p class="text-gray-800">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Metode Pembayaran</h3>
                    <div class="flex items-center gap-2">
                        @switch($order->payment_method)
                            @case('credit_card')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5z" />
                                </svg>
                                <span class="text-gray-800">{{ ucfirst($order->payment_method) }}</span>
                                @break

                            @case('cod')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9l7-7 9 9M5 9l7 7-9-9" />
                                </svg>
                                <span class="text-gray-800">{{ ucfirst($order->payment_method) }}</span>
                                @break

                            @case('transfer')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V5m8 0v6M3 8l7-7 7 7M3 8l7 7 7-7" />
                                </svg>
                                <span class="text-gray-800">{{ ucfirst($order->payment_method) }}</span>
                                @break

                            @default
                                <span class="text-gray-800">{{ ucfirst($order->payment_method) }}</span>
                        @endswitch
                    </div>
                </div>

                <!-- Status Pesanan -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Status Pesanan</h3>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($order->status == 'completed') bg-green-100 text-green-800
                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <!-- Alamat Pengiriman -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Alamat Pengiriman</h3>
                    <p class="text-gray-800">{{ $order->shipping_address }}</p>
                </div>

                <!-- Tombol Kembali -->
                <div class="mt-6">
                    <a href="{{ route('orders.index') }}"
                       class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center block">
                        Kembali ke Riwayat Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
