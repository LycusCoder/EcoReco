@extends('layouts.app')

@section('content')
<div class="container py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Pesanan</h1>

    @forelse ($orders as $order)
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
            <div class="p-6 flex flex-col md:flex-row md:items-center justify-between">
                <!-- Informasi Utama -->
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            Pesanan #{{ $order->id }}
                        </h2>
                        <p class="text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </p>
                    </div>

                    <!-- Status Pesanan -->
                    <div class="mt-2 md:mt-0">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($order->status == 'completed') bg-green-100 text-green-800
                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <!-- Tautan Lihat Detail -->
                <a href="{{ route('orders.show', $order->id) }}"
                   class="text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Detail Pesanan
                </a>
            </div>

            <!-- Detail Pesanan -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Total -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total</h3>
                    <p class="text-lg font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>

                <!-- Metode Pembayaran -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Metode Pembayaran</h3>
                    <div class="flex items-center gap-2">
                        @switch($order->payment_method)
                            @case('credit_card')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5z" />
                                </svg>
                                <span class="text-lg">{{ ucfirst($order->payment_method) }}</span>
                                @break

                            @case('cod')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9l7-7 9 9M5 9l7 7-9-9" />
                                </svg>
                                <span class="text-lg">{{ ucfirst($order->payment_method) }}</span>
                                @break

                            @case('transfer')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V5m8 0v6M3 8l7-7 7 7M3 8l7 7 7-7" />
                                </svg>
                                <span class="text-lg">{{ ucfirst($order->payment_method) }}</span>
                                @break

                            @default
                                <span class="text-lg">{{ ucfirst($order->payment_method) }}</span>
                        @endswitch
                    </div>
                </div>

                <!-- Alamat Pengiriman -->
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Alamat Pengiriman</h3>
                    <p class="text-lg">{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-500">Anda belum memiliki pesanan</p>
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                Mulai Belanja
            </a>
        </div>
    @endforelse
</div>
@endsection
