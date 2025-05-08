@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @include('components.profile.header')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    @include('components.profile.personal-info')
                    @include('components.profile.about-contact')
                </div>
                <div class="space-y-6">
                    @include('components.profile.quick-links')
                    @include('components.profile.change-password')
                </div>
            </div>
        </div>
    </div>

    <style>
        @include('components.profile.styles')
    </style>
    <script>
        @include('components.profile.scripts')
    </script>
@endsection
