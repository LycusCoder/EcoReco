@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

    <!-- Rekomendasi Produk -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            <i class="fas fa-star mr-2 text-yellow-400"></i> Rekomendasi Produk
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
            @foreach ($recommendedProducts as $product)
                @include('components.lamandepan.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>

    <!-- Riwayat Pembelian -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            <i class="fas fa-shopping-cart mr-2 text-blue-500"></i> Riwayat Pembelian
        </h2>
        @if ($purchaseHistory->isEmpty())
            <p class="text-gray-500">Anda belum melakukan pembelian.</p>
        @else
            <div class="space-y-4">
                @foreach ($purchaseHistory as $order)
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <p class="text-sm text-gray-500">Order ID: {{ $order->id }}</p>
                        <ul class="list-disc pl-5">
                            @foreach ($order->orderItems as $item)
                                <li>{{ $item->product->name }} ({{ $item->quantity }} pcs)</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Testimonial -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            <i class="fas fa-comment-dots mr-2 text-green-500"></i> Testimonial Anda
        </h2>
        @if ($userTestimonials->isEmpty())
            <p class="text-gray-500">Anda belum menambahkan testimonial.</p>
        @else
            <div class="space-y-4">
                @foreach ($userTestimonials as $testimonial)
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <p class="text-gray-700">{{ $testimonial->message }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
