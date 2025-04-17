<header class="bg-[#e6f7f9] shadow-md w-full sticky top-0 z-40">

    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo & Brand -->
            @include('components.layouts.logo')

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-6">
                @include('components.layouts.navigation')
            </nav>

            <!-- Right Side Icons -->
            <div class="flex items-center space-x-4">
                <!-- Cart with counter -->
                @include('components.layouts.cart')

                <!-- User Dropdown or Auth Links -->
                @include('components.layouts.user-menu')

                <!-- Mobile Menu Button -->
                <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none p-2"
                    aria-label="Toggle menu" aria-expanded="false">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t shadow-lg transition-all duration-300 ease-in-out">
        <div class="container mx-auto px-4 py-2">
            <nav class="flex flex-col space-y-2">
                @include('components.layouts.mobile-navigation')
            </nav>
        </div>
    </div>
</header>
