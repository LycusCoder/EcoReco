<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        .bg-primary { background-color: #38bdf8; }
        .bg-secondary { background-color: #22c55e; }
        .bg-tech { background-color: #f0f4f8; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-tech font-[Poppins] text-gray-800">
    <div class="min-h-screen flex">
        @include('components.layouts.staff.sidebar')

        <div class="ml-64 flex-1">
            @include('components.layouts.staff.header')

            <main class="p-8">
                @include('components.layouts.staff.stats-cards')

                @include('components.layouts.flash-messages')

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.querySelectorAll('.group').forEach(group => {
            group.addEventListener('click', (e) => {
                e.currentTarget.querySelector('.dropdown-content').classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
