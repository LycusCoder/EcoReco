@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Kategori: {{ $category->name }}</h1>

    @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                @include('components.lamandepan.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-6">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <p class="text-gray-600">Belum ada produk di kategori ini.</p>
    @endif
</div>
@endsection
