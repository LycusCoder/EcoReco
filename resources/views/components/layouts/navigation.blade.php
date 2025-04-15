<a href="{{ route('home') }}"
    class="text-gray-700 hover:text-blue-600 transition-colors flex items-center {{ request()->routeIs('home') ? 'text-blue-600 font-medium' : '' }}">
    <i class="fas fa-home mr-2"></i> Beranda
</a>
<a href="{{ route('recommendations') }}"
    class="text-gray-700 hover:text-blue-600 transition-colors flex items-center {{ request()->routeIs('recommendations') ? 'text-blue-600 font-medium' : '' }}">
    <i class="fas fa-lightbulb mr-2"></i> Rekomendasi
</a>
<a href="{{ route('about') }}"
    class="text-gray-700 hover:text-blue-600 transition-colors flex items-center {{ request()->routeIs('about') ? 'text-blue-600 font-medium' : '' }}">
    <i class="fas fa-circle-info mr-2"></i> Tentang
</a>
