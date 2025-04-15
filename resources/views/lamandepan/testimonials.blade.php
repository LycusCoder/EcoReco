@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8">Testimonials</h1>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">What Our Customers Say</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($testimonials as $testimonial)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-3">
                        <img src="{{ $testimonial->image }}" alt="{{ $testimonial->user->name ?? 'User' }}"
                             class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <h3 class="font-medium">{{ $testimonial->user->name ?? 'Anonymous' }}</h3>
                            <div class="flex text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= 4) {{-- Asumsi rating rata-rata 4 --}}
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"{{ $testimonial->message }}"</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-center">
            <h3 class="text-xl font-semibold mb-4">Want to share your experience?</h3>
            @auth
                <a href="#" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Write a Testimonial
                </a>
            @else
                <p class="text-gray-600 mb-4">Please login to share your testimonial</p>
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Login
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
