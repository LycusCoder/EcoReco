<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoReco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="min-h-screen flex flex-col bg-gray-50">
    <!-- Navbar -->
    <header class="bg-white shadow-md w-full">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <!-- Logo & Brand -->
            <a href="/" class="flex items-center text-2xl font-bold text-blue-600 hover:text-blue-800">
                <i class="fas fa-bag-shopping mr-2"></i> EcoReco
            </a>
            <!-- Mobile Menu Button -->
            <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-6">
                <a href="/" class="text-gray-700 hover:text-blue-600 transition-colors flex items-center">
                    <i class="fas fa-house mr-2"></i> Home
                </a>
                <a href="/recommendations"
                    class="text-gray-700 hover:text-blue-600 transition-colors flex items-center">
                    <i class="fas fa-lightbulb mr-2"></i> Rekomendasi
                </a>
                <a href="/about" class="text-gray-700 hover:text-blue-600 transition-colors flex items-center">
                    <i class="fas fa-circle-info mr-2"></i> Tentang
                </a>
                @auth
                    <a href="/dashboard" class="text-gray-700 hover:text-blue-600 transition-colors flex items-center">
                        <i class="fas fa-gauge-high mr-2"></i> Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="/login" class="text-gray-700 hover:text-blue-600 transition-colors flex items-center">
                        <i class="fas fa-right-to-bracket mr-2"></i> Login
                    </a>
                @endauth
            </nav>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t shadow-lg">
            <nav class="flex flex-col space-y-1 py-3 px-4">
                <a href="/" class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center">
                    <i class="fas fa-house mr-2 text-lg"></i> Home
                </a>
                @auth
                    <a href="/dashboard" class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center">
                        <i class="fas fa-gauge-high mr-2 text-lg"></i> Dashboard
                    </a>
                @endauth
                <a href="/recommendations" class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center">
                    <i class="fas fa-lightbulb mr-2 text-lg"></i> Rekomendasi
                </a>
                <a href="/about" class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center">
                    <i class="fas fa-circle-info mr-2 text-lg"></i> Tentang
                </a>
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 px-4 rounded hover:bg-red-50 text-red-600 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="/login" class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center">
                        <i class="fas fa-right-to-bracket mr-2 text-lg"></i> Login
                    </a>
                    <a href="/register" class="py-2 px-4 rounded hover:bg-blue-50 text-gray-700 flex items-center">
                        <i class="fas fa-user-plus mr-2 text-lg"></i> Register
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-grow container mx-auto px-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-4 text-center md:text-left">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-2 md:mb-0">&copy; 2025 EcoReco. All rights reserved.</div>
            <div class="flex space-x-4 text-xl">
                <a href="https://facebook.com/404xtrap" target="_blank"
                    class="text-white hover:text-yellow-300 transition duration-300">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://x.com/lycusbendln" target="_blank"
                    class="text-white hover:text-yellow-300 transition duration-300">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://linkedin.com/in/nourivex" target="_blank"
                    class="text-white hover:text-yellow-300 transition duration-300">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://instagram.com/richlycus" target="_blank"
                    class="text-white hover:text-yellow-300 transition duration-300">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </footer>

    <script>
        // Toggle mobile menu
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
