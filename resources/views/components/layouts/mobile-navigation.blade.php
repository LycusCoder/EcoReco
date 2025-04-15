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
