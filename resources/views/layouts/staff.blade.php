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
        {{-- Sidebar --}}
        @include('components.layouts.staff.sidebar')

        {{-- Main content wrapper --}}
        <div id="main-content" class="flex-1 transition-all duration-300 ml-64 lg:ml-72">
            {{-- Header --}}
            @include('components.layouts.staff.header')

            {{-- Page content --}}
            <main class="p-8  mx-auto">
                @include('components.layouts.flash-messages')
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Inline scripts --}}
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Elements
            const sidebar = document.getElementById('sidebar');
            const btnSidebar = document.getElementById('sidebar-toggle');
            const btnSidebarHdr = document.getElementById('sidebar-toggle-header');
            const mainContent = document.getElementById('main-content');

            // Toggle sidebar & adjust main-content margin
            function toggleSidebar() {
                const hidden = sidebar.classList.toggle('-translate-x-full');

                if (hidden) {
                    // ketika sidebar disembunyikan → isi konten melebar
                    mainContent.classList.remove('ml-64', 'lg:ml-72');
                    mainContent.classList.add('mx-4');
                } else {
                    // ketika sidebar dibuka → kembalikan margin-left
                    mainContent.classList.add('ml-64', 'lg:ml-72');
                    mainContent.classList.remove('mx-4');
                }
            }

            btnSidebar?.addEventListener('click', toggleSidebar);
            btnSidebarHdr?.addEventListener('click', toggleSidebar);

            // User dropdown toggle
            const userBtn = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('dropdown-menu');

            userBtn?.addEventListener('click', e => {
                e.stopPropagation();
                const open = userDropdown.classList.toggle('visible');
                userDropdown.classList.toggle('opacity-0', !open);
                userDropdown.classList.toggle('invisible', !open);
                userDropdown.classList.toggle('scale-95', !open);
            });

            // Close user dropdown when klik luar
            document.addEventListener('click', e => {
                if (!userDropdown.contains(e.target) && !userBtn.contains(e.target)) {
                    userDropdown.classList.add('opacity-0', 'invisible', 'scale-95');
                    userDropdown.classList.remove('visible');
                }
            });

            // Sidebar “Lainnya” dropdown
            const dropBtn = document.getElementById('dropdown-button');
            const dropContent = document.getElementById('dropdown-content');
            const dropIcon = document.getElementById('dropdown-icon');

            dropBtn?.addEventListener('click', () => {
                const show = dropContent.classList.toggle('hidden');
                dropIcon.style.transform = show ? 'rotate(180deg)' : 'rotate(0deg)';
            });
        });
    </script>
</body>

</html>
