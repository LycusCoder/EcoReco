@extends('layouts.app')

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

        <!-- Rekomendasi Produk -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
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
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-shopping-cart mr-2 text-blue-500"></i>
                Riwayat Pembelian
            </h2>

            @if ($purchaseHistory->isEmpty())
                <p class="text-gray-500">Anda belum melakukan pembelian.</p>
            @else
                <!-- Buat grid di md+, dan overflow-x di sm -->
                <div class="space-y-4 md:grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:space-y-0">
                    @foreach ($purchaseHistory as $order)
                        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col">
                            <p class="text-sm text-gray-500 mb-2">Order ID: {{ $order->id }}</p>
                            <ul class="list-disc pl-5 flex-1 space-y-1 overflow-auto">
                                @foreach ($order->orderItems as $item)
                                    <li class="text-gray-700">{{ $item->product->name }} ({{ $item->quantity }} pcs)</li>
                                @endforeach
                            </ul>
                            <p class="text-xs text-gray-400 mt-2">{{ $order->created_at->format('d M Y') }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Testimonial -->
        <div class="mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-comment-dots mr-2 text-green-500"></i>
                Testimonial Anda
            </h2>

            @if ($userTestimonials->isEmpty())
                <p class="text-gray-500">Anda belum menambahkan testimonial.</p>
            @else
                <div class="space-y-4 md:grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:space-y-0">
                    @foreach ($userTestimonials as $testimonial)
                        <div class="bg-white rounded-lg shadow-md p-4 h-full flex flex-col justify-between">
                            <p class="text-gray-700 mb-4 flex-1">{{ $testimonial->message }}</p>
                            <p class="text-xs text-gray-400 text-right">{{ $testimonial->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
