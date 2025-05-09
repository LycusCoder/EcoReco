<!-- Header -->
<header class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-xl">
    <div class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <!-- Tombol Toggle Sidebar untuk Mobile -->
            <button id="sidebar-toggle-header" class="lg:hidden text-white focus:outline-none">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <!-- Logo/Title -->
            <div class="flex items-center space-x-2">
                <h1 class="text-2xl font-bold text-white tracking-tight">
                    <span class="bg-white/10 backdrop-blur-sm px-3 py-1 rounded-lg">@yield('title', 'Dashboard')</span>
                </h1>
            </div>

            <!-- User Dropdown -->
            <div class="relative" id="user-dropdown-container">
                <button id="user-menu-button" class="flex items-center space-x-2 focus:outline-none">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-white/80">Admin</p>
                    </div>
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white border-2 border-white/30 hover:border-white/50 transition-all duration-300">
                            <i class="fas fa-user text-lg"></i>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdown-menu"
                     class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-white/10 rounded-xl bg-white/90 backdrop-blur-lg shadow-lg ring-1 ring-black/5 opacity-0 invisible scale-95 transition-all duration-200 transform z-50">
                    <div class="px-1 py-1">
                        <a href="#" class="group flex w-full items-center rounded-lg px-3 py-3 text-sm text-gray-700 hover:bg-indigo-500 hover:text-white transition-colors">
                            <i class="fas fa-user-circle mr-3 text-indigo-500 group-hover:text-white"></i>
                            Profil
                        </a>
                        <a href="#" class="group flex w-full items-center rounded-lg px-3 py-3 text-sm text-gray-700 hover:bg-indigo-500 hover:text-white transition-colors">
                            <i class="fas fa-cog mr-3 text-indigo-500 group-hover:text-white"></i>
                            Pengaturan
                        </a>
                    </div>
                    <div class="px-1 py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="group flex w-full items-center rounded-lg px-3 py-3 text-sm text-red-600 hover:bg-red-500 hover:text-white transition-colors">
                                <i class="fas fa-sign-out-alt mr-3 text-red-500 group-hover:text-white"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
