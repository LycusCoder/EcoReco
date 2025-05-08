<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8">
    <div class="flex items-center space-x-4 mb-6 md:mb-0">
        <div class="relative">
            <div class="h-20 w-20 rounded-full bg-gradient-to-r from-blue-500 to-teal-400 flex items-center justify-center text-white text-2xl font-bold">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <button class="absolute -bottom-2 -right-2 bg-white p-1.5 rounded-full shadow-md hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
            <p class="text-gray-600">{{ $user->email }}</p>
        </div>
    </div>
    <div class="flex space-x-3 relative">
        <button id="dropdown-button" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
            </svg>
            Lainnya
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div id="dropdown-menu" class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-lg overflow-hidden z-10">
            <ul class="py-2">
                <li><a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition">Pesanan Saya</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 transition">Logout</button></form>
                </li>
            </ul>
        </div>
    </div>
</div>
