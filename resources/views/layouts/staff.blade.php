<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        .bg-primary {
            background-color: #38bdf8;
        }

        .bg-secondary {
            background-color: #22c55e;
        }

        .bg-tech {
            background-color: #f0f4f8;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-tech font-[Poppins] text-gray-800">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="bg-gray-800 w-64 shadow-xl fixed h-full">
            <div class="p-4 border-b border-gray-700">
                <h2 class="text-2xl font-bold text-white">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 inline-block mr-2">
                    Staff Panel
                </h2>
            </div>
            <nav class="mt-4">
                <a href="{{ route('staff.dashboard') }}"
                    class="flex items-center px-6 py-3 text-white hover:bg-gray-700 group transition-colors">
                    <i class="fas fa-home mr-3 text-green-400 group-hover:text-green-300"></i>
                    Dashboard
                </a>

                <!-- Menu Produk -->
                <div class="px-4 mt-4 pt-4">
                    <p class="text-xs font-semibold text-green-400 uppercase mb-2">Statistik Produk</p>
                    <div class="space-y-2">
                        <div class="bg-gray-700 p-3 rounded-lg">
                            <p class="text-sm text-green-200">Total Produk</p>
                            <p class="text-xl font-bold text-white">{{ $totalProducts }}</p>
                        </div>
                        <div class="bg-gray-700 p-3 rounded-lg">
                            <p class="text-sm text-blue-300">Bulan Ini</p>
                            <p class="text-xl font-bold text-white">{{ $monthlyProducts }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tabs Produk -->
                <div class="mt-6 px-2">
                    <a href="{{ route('staff.products.index') }}"
                        class="flex items-center px-6 py-3 text-sm text-white hover:bg-gray-700
                              {{ request()->routeIs('staff.products.*') ? 'bg-gray-700 border-l-4 border-green-400' : '' }}">
                        <i class="fas fa-box-open mr-3 text-green-400"></i>
                        Lihat Produk
                    </a>
                    <a href="{{ route('staff.products.create') }}"
                        class="flex items-center px-6 py-3 text-sm text-white hover:bg-gray-700">
                        <i class="fas fa-plus-circle mr-3 text-green-400"></i>
                        Tambah Produk
                    </a>
                    <div class="px-6 py-3 text-sm text-gray-400">
                        <div class="cursor-pointer hover:text-green-400">
                            Lainnya <i class="fas fa-chevron-down ml-1"></i>
                            <div class="ml-4 mt-2 space-y-2 hidden dropdown-content">
                                <a href="#" class="block text-gray-300 hover:text-green-400">Kategori</a>
                                <a href="#" class="block text-gray-300 hover:text-green-400">Arsip</a>
                                <a href="#" class="block text-gray-300 hover:text-green-400">Export Data</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="ml-64 flex-1">
            <!-- Header -->
            <header class="bg-primary shadow-lg">
                <div class="flex items-center justify-between px-8 py-4">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-white">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative group">
                            <button class="flex items-center text-white hover:text-green-200 transition-colors">
                                <span class="mr-2">{{ Auth::user()->name }}</span>
                                <i class="fas fa-user-circle text-xl"></i>
                            </button>
                            <div
                                class="absolute right-0 hidden group-hover:block bg-white shadow-lg rounded-lg w-48 mt-2">
                                <a href="#" class="block px-4 py-3 text-gray-800 hover:bg-gray-100">Profil</a>
                                <a href="#" class="block px-4 py-3 text-gray-800 hover:bg-gray-100">Pengaturan</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-3 text-red-600 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Card Produk Terbaru -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Produk Baru</h3>
                                <p class="text-2xl font-bold text-primary mt-2">{{ $newProductsCount }}</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-full">
                                <i class="fas fa-boxes text-green-600 text-2xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-green-600">
                            <i class="fas fa-arrow-up mr-1"></i> 15% dari kemarin
                        </div>
                    </div>

                    <!-- Card Pesanan Baru -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Pesanan Baru</h3>
                                <p class="text-2xl font-bold text-primary mt-2">{{ $newOrdersCount }}</p>
                            </div>
                            <div class="bg-blue-100 p-4 rounded-full">
                                <i class="fas fa-shopping-cart text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-blue-600">
                            <i class="fas fa-arrow-up mr-1"></i> 8% dari minggu lalu
                        </div>
                    </div>

                    <!-- Card Penjualan -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Penjualan</h3>
                                <p class="text-2xl font-bold text-primary mt-2">Rp {{ number_format($monthlySales) }}
                                </p>
                            </div>
                            <div class="bg-purple-100 p-4 rounded-full">
                                <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-purple-600">
                            <i class="fas fa-arrow-up mr-1"></i> 22% dari bulan lalu
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                @include('components.layouts.flash-messages')

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Dropdown handler
        document.querySelectorAll('.group').forEach(group => {
            group.addEventListener('click', (e) => {
                e.currentTarget.querySelector('.dropdown-content').classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>
