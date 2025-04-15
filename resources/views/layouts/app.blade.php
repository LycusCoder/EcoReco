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

    <!-- Navigation -->
    <header class="bg-white shadow-md w-full sticky top-0 z-40">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}"
                        class="flex items-center text-2xl font-bold text-blue-600 hover:text-blue-800 transition-colors">
                        <i class="fas fa-leaf mr-2 text-green-600"></i>
                        <span>EcoReco</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}"
                        class="text-gray-700 hover:text-blue-600 transition-colors flex items-center {{ request()->routeIs('home') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-home mr-2"></i> Home
                    </a>

                    <a href="{{ route('recommendations') }}"
                        class="text-gray-700 hover:text-blue-600 transition-colors flex items-center {{ request()->routeIs('recommendations') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-lightbulb mr-2"></i> Rekomendasi
                    </a>

                    <a href="{{ route('about') }}"
                        class="text-gray-700 hover:text-blue-600 transition-colors flex items-center {{ request()->routeIs('about') ? 'text-blue-600 font-medium' : '' }}">
                        <i class="fas fa-circle-info mr-2"></i> Tentang
                    </a>
                </nav>

                <!-- Right side icons -->
                <div class="flex items-center space-x-4">
                    <!-- Cart with counter -->
                    <a href="{{ route('cart.index') }}"
                        class="relative p-2 text-gray-700 hover:text-blue-600 transition-colors"
                        aria-label="Shopping cart">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center
                 {{ cart_count() > 0 ? '' : 'hidden' }}">
                            {{ cart_count() }}
                        </span>
                    </a>

                    <!-- User dropdown or auth links -->
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-1 focus:outline-none"
                                aria-label="User menu">
                                <span
                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-user"></i>
                                </span>
                                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200"
                                    :class="{ 'transform rotate-180': open }"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                    <i class="fas fa-user-circle mr-2"></i> Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="hidden md:flex items-center space-x-2">
                            <a href="{{ route('login') }}"
                                class="px-3 py-1 text-gray-700 hover:text-blue-600 transition-colors">
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                Register
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile menu button -->
                    <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none p-2"
                        aria-label="Toggle menu" aria-expanded="false">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu"
            class="hidden md:hidden bg-white border-t shadow-lg transition-all duration-300 ease-in-out">
            <div class="container mx-auto px-4 py-2">
                <nav class="flex flex-col space-y-2">
                    <a href="{{ route('home') }}"
                        class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-home mr-3 text-lg"></i> Home
                    </a>

                    <a href="{{ route('recommendations') }}"
                        class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center {{ request()->routeIs('recommendations') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-lightbulb mr-3 text-lg"></i> Rekomendasi
                    </a>

                    <a href="{{ route('about') }}"
                        class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center {{ request()->routeIs('about') ? 'bg-blue-50 text-blue-600' : '' }}">
                        <i class="fas fa-circle-info mr-3 text-lg"></i> Tentang
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center">
                            <i class="fas fa-tachometer-alt mr-3 text-lg"></i> Dashboard
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                class="w-full text-left py-2 px-4 rounded hover:bg-red-50 text-red-600 flex items-center">
                                <i class="fas fa-sign-out-alt mr-3"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center">
                            <i class="fas fa-right-to-bracket mr-3 text-lg"></i> Login
                        </a>

                        <a href="{{ route('register') }}"
                            class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center">
                            <i class="fas fa-user-plus mr-3 text-lg"></i> Register
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="flex-grow container mx-auto px-4 py-6">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About -->
                <div class="md:col-span-2">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class="fas fa-leaf mr-2"></i> EcoReco
                    </h3>
                    <p class="text-blue-100">
                        Your sustainable shopping destination. We're committed to providing eco-friendly products
                        that help reduce environmental impact.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}"
                                class="text-blue-100 hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('recommendations') }}"
                                class="text-blue-100 hover:text-white transition-colors">Recommendations</a></li>
                        <li><a href="{{ route('about') }}"
                                class="text-blue-100 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ route('contact') }}"
                                class="text-blue-100 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-blue-200"></i>
                            <span>contact@ecoreco.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2 text-blue-200"></i>
                            <span>+62 123 4567 890</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-200"></i>
                            <span>Jakarta, Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-blue-500 mt-8 pt-6 flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    &copy; {{ date('Y') }} EcoReco. All rights reserved.
                </div>

                <div class="flex space-x-4 text-xl">
                    <a href="https://facebook.com/404xtrap" target="_blank" rel="noopener noreferrer"
                        class="text-white hover:text-blue-200 transition-colors" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://x.com/lycusbendln" target="_blank" rel="noopener noreferrer"
                        class="text-white hover:text-blue-200 transition-colors" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://linkedin.com/in/nourivex" target="_blank" rel="noopener noreferrer"
                        class="text-white hover:text-blue-200 transition-colors" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://instagram.com/richlycus" target="_blank" rel="noopener noreferrer"
                        class="text-white hover:text-blue-200 transition-colors" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

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
