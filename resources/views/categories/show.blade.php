@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-bold">Produk dalam Kategori: {{ $category->name }}</h1>
        <span class="ml-4 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
            {{ $products->total() }} produk
        </span>
    </div>

    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-700">Belum ada produk dalam kategori ini</h2>
            <p class="text-gray-500 mt-2">Kami akan segera menambahkan produk terkait</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    @endif
</div>
@endsection
