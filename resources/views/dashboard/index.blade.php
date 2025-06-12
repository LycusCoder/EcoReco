@extends('layouts.app')

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-blue-200 pb-2">Dashboard</h1>

        <!-- Rekomendasi Produk -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-star mr-2 text-yellow-400"></i>
                Rekomendasi Produk
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($recommendedProducts as $product)
                    @include('components.lamandepan.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>

        <!-- Riwayat Pembelian -->
<div class="mb-10">
    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 114 0 2 2 0 01-4 0z" />
        </svg>
        Riwayat Pembelian
    </h2>

    @if ($purchaseHistory->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-500">Anda belum melakukan pembelian.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($purchaseHistory as $order)
                <div class="bg-white backdrop-blur-sm bg-opacity-80 rounded-xl shadow-lg p-4 border border-gray-100 transition-all duration-300 hover:shadow-xl">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-800">Order ID: #{{ $order->id }}</p>
                            <ul class="list-disc pl-5 space-y-1 mt-2">
                                @foreach ($order->orderItems as $item)
                                    <li class="text-gray-700 text-sm">{{ $item->product->name }} ({{ $item->quantity }} pcs)</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="text-xs text-gray-400">{{ $order->created_at->format('d M Y') }}</span>
                            <div class="flex items-center space-x-1">
                                <span class="text-yellow-400 text-sm">
                                    {{ str_repeat('★', $order->rating ?? 0) }}
                                    {{ str_repeat('☆', 5 - ($order->rating ?? 0)) }}
                                    ({{ $order->rating_count ?? 0 }})
                                </span>
                                <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 text-sm hover:underline">Lihat</a>
                            </div>
                        </div>
                    </div>
                    <!-- Status Pesanan -->
                    <div class="mt-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @if($order->status == 'completed') bg-green-100 text-green-800
                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

        <!-- Testimonial -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-comment-dots mr-2 text-green-500"></i>
                Testimonial Anda
            </h2>

            @if ($userTestimonials->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <p class="text-gray-500">Anda belum menambahkan testimonial.</p>
                    <a href="" class="mt-4 inline-block bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                        Tambah Testimonial
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($userTestimonials as $testimonial)
                        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow duration-200">
                            <p class="text-gray-700 mb-4 flex-1">{{ $testimonial->message }}</p>
                            <p class="text-xs text-gray-400 text-right">{{ $testimonial->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection