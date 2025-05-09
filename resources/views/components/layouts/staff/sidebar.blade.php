<aside
    class="bg-gradient-to-b from-gray-800 to-gray-900 w-64 shadow-2xl fixed h-full overflow-y-auto transition-all duration-300 hover:shadow-purple-500/20 z-50">
    <!-- Logo/Header Section -->
    <div class="p-5 border-b border-gray-700/50 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8 object-contain rounded-lg bg-white/5 p-1">
            <h2
                class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-teal-300">
                Staff Panel
            </h2>
        </div>
        <button class="text-gray-400 hover:text-white lg:hidden">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-1">
        <!-- Dashboard Link -->
        <a href="{{ route('staff.dashboard') }}"
            class="flex items-center px-4 py-3 rounded-xl text-white hover:bg-gray-700/50 group transition-all duration-200
                  {{ request()->routeIs('staff.dashboard') ? 'bg-gray-700/50 shadow-md shadow-green-500/10 border-l-4 border-green-400' : '' }}">
            <div
                class="p-2 mr-3 rounded-lg bg-gradient-to-br from-green-500 to-teal-400 group-hover:from-green-400 group-hover:to-teal-300">
                <i class="fas fa-home text-white text-sm"></i>
            </div>
            <span class="font-medium">Dashboard</span>
            <div class="ml-auto">
                <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
            </div>
        </a>

        <!-- Stats Section -->
        <div class="mt-6">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Statistik Produk</p>
            <div class="grid grid-cols-2 gap-3 px-2">
                <div
                    class="bg-gray-700/40 hover:bg-gray-700/60 backdrop-blur-sm p-3 rounded-xl border border-gray-600/30 transition-all duration-200 group">
                    <p class="text-xs text-green-300/80 group-hover:text-green-200">Total Produk</p>
                    <p class="text-xl font-bold text-white mt-1">{{ $totalProducts }}</p>
                    <div class="h-1 mt-2 bg-gradient-to-r from-green-500 to-transparent rounded-full"></div>
                </div>
                <div
                    class="bg-gray-700/40 hover:bg-gray-700/60 backdrop-blur-sm p-3 rounded-xl border border-gray-600/30 transition-all duration-200 group">
                    <p class="text-xs text-blue-300/80 group-hover:text-blue-200">Bulan Ini</p>
                    <p class="text-xl font-bold text-white mt-1">{{ $monthlyProducts }}</p>
                    <div class="h-1 mt-2 bg-gradient-to-r from-blue-500 to-transparent rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="mt-8">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Manajemen Produk</p>

            <div class="space-y-1">
                <a href="{{ route('staff.products.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-white hover:bg-gray-700/50 group transition-all duration-200
                          {{ request()->routeIs('staff.products.index') ? 'bg-gray-700/50 shadow-md shadow-purple-500/10 border-l-4 border-purple-400' : '' }}">
                    <div
                        class="p-2 mr-3 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-400 group-hover:from-purple-400 group-hover:to-indigo-300">
                        <i class="fas fa-box-open text-white text-sm"></i>
                    </div>
                    <span class="font-medium">Lihat Produk</span>
                    <span
                        class="ml-auto text-xs bg-purple-500/20 text-purple-300 px-2 py-1 rounded-full">{{ $totalProducts }}</span>
                </a>

                <a href="{{ route('staff.products.create') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-white hover:bg-gray-700/50 group transition-all duration-200
                          {{ request()->routeIs('staff.products.create') ? 'bg-gray-700/50 shadow-md shadow-blue-500/10 border-l-4 border-blue-400' : '' }}">
                    <div
                        class="p-2 mr-3 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-400 group-hover:from-blue-400 group-hover:to-cyan-300">
                        <i class="fas fa-plus-circle text-white text-sm"></i>
                    </div>
                    <span class="font-medium">Tambah Produk</span>
                </a>

                <!-- Dropdown Section -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-white hover:bg-gray-700/50 transition-all duration-200">
                        <div class="flex items-center">
                            <div class="p-2 mr-3 rounded-lg bg-gradient-to-br from-gray-500 to-gray-400">
                                <i class="fas fa-ellipsis-h text-white text-sm"></i>
                            </div>
                            <span class="font-medium">Lainnya</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-200"
                            :class="{ 'transform rotate-180': open }"></i>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="ml-12 mt-1 space-y-1 bg-gray-800/50 rounded-lg p-1 border border-gray-700/50">
                        <a href="#"
                            class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700/50 rounded-lg hover:text-white transition-colors">
                            <i class="fas fa-tags mr-2 text-purple-400"></i> Kategori
                        </a>
                        <a href="#"
                            class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700/50 rounded-lg hover:text-white transition-colors">
                            <i class="fas fa-archive mr-2 text-blue-400"></i> Arsip
                        </a>
                        <a href="#"
                            class="block px-3 py-2 text-sm text-gray-300 hover:bg-gray-700/50 rounded-lg hover:text-white transition-colors">
                            <i class="fas fa-file-export mr-2 text-green-400"></i> Export Data
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Section -->
        <div class="mt-8">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Pesanan Pelanggan</p>

            <div class="space-y-1">
                <a href="{{ route('staff.orders') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-white hover:bg-gray-700/50 group transition-all duration-200
                  {{ request()->routeIs('staff.orders') ? 'bg-gray-700/50 shadow-md shadow-blue-500/10 border-l-4 border-blue-400' : '' }}">
                    <div
                        class="p-2 mr-3 rounded-lg bg-gradient-to-br from-green-500 to-emerald-400 group-hover:from-green-400 group-hover:to-emerald-300">
                        <i class="fas fa-shopping-cart text-white text-sm"></i>
                    </div>
                    <span class="font-medium">Cek Pesanan</span>
                    @if ($newOrdersCount ?? 0 > 0)
                        <span class="ml-auto text-xs bg-green-500/20 text-green-300 px-2 py-1 rounded-full">
                            {{ $newOrdersCount ?? 0 }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700/50 bg-gray-800/50 backdrop-blur-sm">
        <div class="flex items-center space-x-3">
            <div class="relative">
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white">
                    <i class="fas fa-user text-lg"></i>
                </div>
                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-gray-800">
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400">Admin</p>
            </div>
        </div>
    </div>
</aside>

<script src="//unpkg.com/alpinejs" defer></script>
