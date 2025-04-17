<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f0f4f8] font-sans leading-normal tracking-normal text-[#111827]">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="bg-[#111827] w-64 fixed h-full shadow-lg">
            <div class="p-4">
                <h2 class="text-xl font-bold text-white">Staff Panel</h2>
            </div>
            <nav class="mt-4">
                <a href="{{ route('staff.dashboard') }}"
                    class="block p-4 text-gray-300 hover:bg-[#22c55e] hover:text-white transition duration-300">
                    <i class="fas fa-home mr-3"></i> Dashboard
                </a>

                <!-- Menu Produk -->
                <div class="border-t border-gray-700 mt-4 pt-4">
                    <div class="px-4 mb-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase mb-2">Manajemen Produk</p>
                        <div class="space-y-2">
                            <div class="bg-[#1e293b] p-3 rounded-lg">
                                <p class="text-sm text-gray-400">Total Produk</p>
                                <p class="text-xl font-bold text-white">{{ $totalProducts }}</p>
                            </div>
                            <div class="bg-[#1e293b] p-3 rounded-lg">
                                <p class="text-sm text-green-400">Bulan Ini</p>
                                <p class="text-xl font-bold text-green-500">{{ $monthlyProducts }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Produk -->
                    <div class="px-2">
                        <a href="{{ route('staff.products.index') }}"
                            class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-[#22c55e] hover:text-white rounded-lg transition duration-300
                                  {{ request()->routeIs('staff.products.*') ? 'bg-[#22c55e] border-l-4 border-green-500' : '' }}">
                            <i class="fas fa-box-open mr-3 text-gray-400"></i>
                            Lihat Produk
                        </a>
                        <a href="{{ route('staff.products.create') }}"
                            class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-[#22c55e] hover:text-white rounded-lg transition duration-300">
                            <i class="fas fa-plus-circle mr-3 text-gray-400"></i>
                            Tambah Produk
                        </a>
                        <div class="px-4 py-3 text-sm text-gray-400">
                            Lainnya ▼
                            <div class="ml-4 mt-2 space-y-2">
                                <a href="#" class="block text-gray-400 hover:text-[#22c55e] text-sm transition duration-300">Kategori</a>
                                <a href="#" class="block text-gray-400 hover:text-[#22c55e] text-sm transition duration-300">Arsip</a>
                                <a href="#" class="block text-gray-400 hover:text-[#22c55e] text-sm transition duration-300">Export Data</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="ml-64 flex-1">
            <!-- Header -->
            <header class="bg-[#38bdf8] shadow-md">
                <div class="flex items-center justify-between px-8 py-4">
                    <div class="flex items-center">
                        <img src="{{ asset('logo.png') }}" alt="EcoReco Logo" class="h-6 mr-2">
                        <h1 class="text-xl font-semibold text-white">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center">
                        <!-- User dropdown -->
                        <div class="relative">
                            <button class="flex items-center focus:outline-none">
                                <span class="mr-2 text-white">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow-md border border-[#e2e8f0]">
                        <h3 class="text-lg font-semibold text-[#111827]">Produk Terbaru</h3>
                        <p class="text-[#475569]">{{ $newProductsCount }} produk baru ditambahkan hari ini.</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md border border-[#e2e8f0]">
                        <h3 class="text-lg font-semibold text-[#111827]">Pesanan Baru</h3>
                        <p class="text-[#475569]">{{ $newOrdersCount }} pesanan baru hari ini.</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-md border border-[#e2e8f0]">
                        <h3 class="text-lg font-semibold text-[#111827]">Penjualan Bulan Ini</h3>
                        <p class="text-[#475569]">Rp {{ number_format($monthlySales) }}</p>
                    </div>
                </div>
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
