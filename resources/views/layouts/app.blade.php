<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EcoReco - Your sustainable shopping destination">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EcoReco - Sustainable Shopping')</title>
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <!-- Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Additional meta tags -->
    @stack('meta')
    <!-- Additional styles -->
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-gray-50 antialiased text-gray-800">
    <!-- Skip to content link for accessibility -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only fixed top-2 left-2 z-50 bg-blue-600 text-white px-4 py-2 rounded">
        Skip to content
    </a>
    <!-- Header -->
    @include('components.layouts.header')
    <!-- Main Content -->
    <main id="main-content" class="flex-grow container mx-auto px-4 py-6">
        <!-- Flash Messages -->
        @include('components.layouts.flash-messages')
        @yield('content')
    </main>
    <!-- Footer -->
    @include('components.layouts.footer')
    <!-- Scripts -->
    <script>
        // Toggle mobile menu with better accessibility
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            menu.classList.toggle('hidden');
            this.setAttribute('aria-expanded', !isExpanded);
            // Update icon
            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
        // Close mobile menu when clicking on a link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.add('hidden');
                document.getElementById('menu-toggle').setAttribute('aria-expanded', 'false');
                document.getElementById('menu-toggle').querySelector('i').classList.remove('fa-times');
                document.getElementById('menu-toggle').querySelector('i').classList.add('fa-bars');
            });
        });
    </script>
    <!-- Additional scripts -->
    @stack('scripts')
</body>
</html>
