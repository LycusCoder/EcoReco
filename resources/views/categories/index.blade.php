@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Kategori Produk</h1>
    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
        @foreach($displayCategories as $cat)
            <a href="{{ route('products.by.category', $cat->slug) }}"
               class="flex flex-col items-center p-4 bg-white rounded-lg shadow hover:shadow-md transition">
                <img src="{{ asset('storage/' . $cat->icon) }}" alt="{{ $cat->name }}"
                     class="w-12 h-12 mb-2 object-contain">
                <span class="text-sm font-medium text-gray-700">{{ $cat->name }}</span>
            </a>
        @endforeach
    </div>

    <!-- Modal Lihat Semua -->
    @include('components.lamandepan.category-modal', ['allCategories' => $allCategories])
</div>
@endsection
