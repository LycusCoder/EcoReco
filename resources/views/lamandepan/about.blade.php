@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8">About Us</h1>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Our Story</h2>
            <p class="text-gray-600 mb-4">
                EcoReco was founded in 2023 with a mission to provide sustainable and eco-friendly products
                to consumers who care about the environment.
            </p>
            <p class="text-gray-600">
                We believe that small changes in our daily shopping habits can make a big difference
                for our planet. That's why we carefully curate our product selection to ensure they meet
                our sustainability standards.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Our Mission</h2>
            <ul class="list-disc pl-5 text-gray-600 space-y-2">
                <li>Reduce environmental impact through sustainable products</li>
                <li>Educate consumers about eco-friendly alternatives</li>
                <li>Support ethical and responsible manufacturers</li>
                <li>Promote a circular economy</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Meet Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($teamMembers as $member)
                <div class="text-center">
                    <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}"
                         class="w-32 h-32 rounded-full mx-auto mb-3">
                    <h3 class="font-medium">{{ $member['name'] }}</h3>
                    <p class="text-gray-500 text-sm mb-2">{{ $member['role'] }}</p>
                    <p class="text-gray-600 text-sm">{{ $member['bio'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
