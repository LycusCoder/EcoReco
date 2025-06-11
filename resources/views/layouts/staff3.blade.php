<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - @yield('title', 'Staff Dashboard')</title>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('styles') <!-- Untuk tambahan CSS jika ada -->
</head>
<body class="bg-gray-100">
    <!-- Sidebar (Opsional) -->
    <div class="flex">
        <aside class="w-64 bg-gray-800 text-white p-4 h-screen fixed">
            <h2 class="text-2xl font-bold mb-6">Menu Staff</h2>
            <ul>
                <li class="mb-2"><a href="{{ route('staff.dashboard') }}" class="hover:text-gray-300">Dashboard</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 w-full p-6">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts') <!-- Untuk tambahan script dari partial -->
</body>
</html>