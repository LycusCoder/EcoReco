@extends('layouts.app')

@section('content')
<div class="container py-8">
    <h1 class="text-2xl font-bold mb-6">Hasil Pencarian untuk "{{ $query }}"</h1>

    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                @include('components.lamandepan.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-700">Produk tidak ditemukan</h2>
            <p class="text-gray-500 mt-2">Tidak ada produk yang cocok dengan pencarian Anda</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    @endif
</div>
@endsection
