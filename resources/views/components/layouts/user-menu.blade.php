@auth
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center space-x-1 focus:outline-none" aria-label="User menu">
            <span class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                <i class="fas fa-user"></i>
            </span>
            <span class="hidden md:inline">{{ Auth::user()->name }}</span>
            <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200"
                :class="{ 'transform rotate-180': open }"></i>
        </button>
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>

            @if (auth()->check() && in_array(auth()->id(), [1, 2, 3, 4, 5]))
                <a href="{{ route('staff.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                    <i class="fas fa-users-cog mr-2"></i> Dashboard Staff
                </a>
            @endif

            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                <i class="fas fa-shopping-bag mr-2"></i> Pesanan Saya
            </a>

            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                <i class="fas fa-user-circle mr-2"></i> Profile
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </div>
@else
    <div class="hidden md:flex items-center space-x-2">
        <a href="{{ route('login') }}" class="px-3 py-1 text-gray-700 hover:text-blue-600 transition-colors">
            Login
        </a>
        <a href="{{ route('register') }}"
            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
            Register
        </a>
    </div>
@endauth
