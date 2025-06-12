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
    <div class="bg-white backdrop-blur-sm bg-opacity-80 rounded-xl shadow-lg p-6 sticky top-4 space-y-5 border border-gray-100 transition-all duration-300 hover:shadow-xl">
        <h2 class="text-xl font-bold flex items-center text-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Informasi Pesanan
        </h2>

        <!-- Tanggal Pesanan -->
        <div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Pesanan</h3>
            <p class="text-gray-700 mt-1">{{ $order->created_at->format('d M Y H:i') }}</p>
        </div>

        <!-- Metode Pembayaran -->
        <div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Metode Pembayaran</h3>
            <div class="flex items-center gap-2 mt-1">
                @switch($order->payment_method)
                    @case('credit_card')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v2H4V6zm0 4h12v2H4v-2zm0 4h6v2H4v-2z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">{{ ucfirst($order->payment_method) }}</span>
                        @break

                    @case('cod')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.965 1.586a1 1 0 01.622 1.11l-.344 1.032a1 1 0 01-.94.651H13v4h1.5a1 1 0 110 2H5a1 1 0 110-2H6.5V7H5a1 1 0 11-.344-1.94l.344-1.033a1 1 0 01.622-1.11L10 3.323V2a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">{{ ucfirst($order->payment_method) }}</span>
                        @break

                    @case('transfer')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm10 3a1 1 0 11-2 0 1 1 0 012 0zm-4 2a1 1 0 11-2 0 1 1 0 012 0zM5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">{{ ucfirst($order->payment_method) }}</span>
                        @break

                    @default
                        <span class="text-gray-700">{{ ucfirst($order->payment_method) }}</span>
                @endswitch
            </div>
        </div>

        <!-- Status Pesanan -->
        <div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Pesanan</h3>
            <span class="inline-flex items-center px-3 py-1 mt-1 rounded-full text-xs font-medium
                @if($order->status == 'completed') bg-green-100 text-green-800
                @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                @else bg-yellow-100 text-yellow-800 @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <!-- Alamat Pengiriman -->
        <div>
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat Pengiriman</h3>
            <p class="text-gray-700 mt-1">{{ $order->shipping_address }}</p>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-6 grid grid-cols-1 gap-3">
            <a href="{{ route('orders.previewInvoice', $order->id) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-full transition-colors text-center">
                Lihat Invoice
            </a>
            <a href="{{ route('orders.previewPDF', $order->id) }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-full transition-colors text-center">
                Unduh Invoice PDF
            </a>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-4">
            <a href="{{ route('orders.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-full transition-colors text-center block">
                Kembali ke Riwayat Pesanan
            </a>
        </div>
    </div>
</div>
    </div>
</div>
@endsection