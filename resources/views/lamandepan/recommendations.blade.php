@extends('layouts.app')

@section('content')
<div class="container py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Recommendations For You</h1>

    @if($recommendedProducts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recommendedProducts as $product)
                @include('components.lamandepan.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">How We Recommend Products</h2>
            <p class="text-gray-600 mb-4">
                Our recommendation system analyzes your browsing history, purchase behavior,
                and ratings to suggest products you might like.
            </p>

            @auth
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-medium text-blue-800 mb-2">Personalization Tips</h3>
                    <ul class="list-disc pl-5 text-blue-700 space-y-1">
                        <li>Rate products you've purchased to improve recommendations</li>
                        <li>Browse different categories to expand your preferences</li>
                        <li>Update your profile with interests for better suggestions</li>
                    </ul>
                </div>
            @else
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <h3 class="font-medium text-yellow-800 mb-2">Get Better Recommendations</h3>
                    <p class="text-yellow-700 mb-3">
                        Create an account or login to get personalized recommendations based on your preferences.
                    </p>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        Login / Register
                    </a>
                </div>
            @endauth
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-lightbulb text-4xl text-yellow-400 mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-700">No Recommendations Yet</h2>
            <p class="text-gray-500 mt-2">
                @auth
                    Start browsing our products to get personalized recommendations.
                @else
                    Login to get personalized recommendations based on your preferences.
                @endauth
            </p>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                Browse Products
            </a>
        </div>
    @endif
</div>
@endsection
