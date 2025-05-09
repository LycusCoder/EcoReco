@extends('layouts.staff')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header with Gradient -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    Staff Dashboard
                </h1>
                <p class="text-sm text-gray-500 mt-2 flex items-center">
                    <i class="fas fa-clock mr-1"></i>
                    Last Update: {{ now()->format('d M Y H:i') }}
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="relative inline-block text-left">
                    <button id="dropdown-button"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span id="period-label">Hari Ini</span>
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="dropdown-panel" class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            @foreach(['today'=>'Hari Ini','week'=>'Minggu Ini','month'=>'Bulan Ini','year'=>'Tahun Ini','all'=>'Total'] as $p=>$lbl)
                                <a href="#" class="period-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" data-period="{{ $p }}">{{ $lbl }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        @php
            $summaryCards = [
                ['title'=>'Total Pesanan','value'=>$timeFrameData['all']['ordersCount'],'icon'=>'fa-shopping-cart','color'=>'blue'],
                ['title'=>'Total Produk','value'=>$timeFrameData['all']['productsCount'],'icon'=>'fa-boxes','color'=>'purple'],
                ['title'=>'Total Penjualan','value'=>$timeFrameData['all']['salesAmount'],'icon'=>'fa-chart-line','color'=>'green','isCurrency'=>true],
                ['title'=>'Pesanan Bulan Ini','value'=>$timeFrameData['month']['ordersCount'],'icon'=>'fa-calendar-alt','color'=>'yellow'],
                ['title'=>'Pendapatan Bulan Ini','value'=>$timeFrameData['month']['salesAmount'],'icon'=>'fa-wallet','color'=>'red','isCurrency'=>true],
            ];
        @endphp

        @foreach($summaryCards as $card)
            @include('components.staff.card-summary', $card)
        @endforeach
    </div>

    <!-- Timeframe Statistics Cards -->
    @php
        $stats = [
            ['title'=>'Produk Baru','key'=>'productsCount','icon'=>'fa-box-open','color'=>'purple'],
            ['title'=>'Pesanan Baru','key'=>'ordersCount','icon'=>'fa-shopping-bag','color'=>'blue'],
            ['title'=>'Penjualan','key'=>'salesAmount','icon'=>'fa-money-bill-wave','color'=>'green'],
        ];
        $periods = ['today'=>'Hari Ini','week'=>'Minggu Ini','month'=>'Bulan Ini','year'=>'Tahun Ini','all'=>'Total'];
    @endphp
    <div id="stats-dashboard" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" data-timeframe='@json($timeFrameData)'>
        @foreach($stats as $stat)
            @include('components.staff.card-statistic', array_merge($stat, ['initial'=>0, 'periods'=>$periods]))
        @endforeach
    </div>

    <!-- Recent Data Section -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Aktivitas Terkini</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('components.staff.recent-orders', ['orders'=>$recentData['orders']])
            @include('components.staff.recent-products', ['products'=>$recentData['products']])
            @include('components.staff.recent-testimonials', ['testimonials'=>$recentData['testimonials']])
        </div>
    </div>

    <!-- Quick Stats Chart -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Statistik Pesanan</h3>
            <div class="flex space-x-2 mt-3 sm:mt-0">
                @foreach(['today'=>'Hari','week'=>'Minggu','month'=>'Bulan','year'=>'Tahun'] as $p=>$lbl)
                    <button class="timeframe-btn px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-600" data-period="{{ $p }}">{{ $lbl }}</button>
                @endforeach
            </div>
        </div>
        <div class="relative">
            <canvas id="ordersChart" class="w-full h-64"></canvas>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Dropdown periode
            const dropdownButton = document.getElementById('dropdown-button');
            const dropdownPanel = document.getElementById('dropdown-panel');
            dropdownButton.addEventListener('click', () => dropdownPanel.classList.toggle('hidden'));
            document.addEventListener('click', e => {
                if (!dropdownButton.contains(e.target) && !dropdownPanel.contains(e.target)) {
                    dropdownPanel.classList.add('hidden');
                }
            });

            // Data timeframe
            const dash = document.getElementById('stats-dashboard');
            const tf = JSON.parse(dash.dataset.timeframe);
            let period = 'today';

            // Format rupiah
            const fmt = v => new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(v);

            // Update stat kartu kecil
            function updateStats() {
                document.getElementById('productsCount').textContent = tf[period].productsCount;
                document.getElementById('ordersCount').textContent = tf[period].ordersCount;
                document.getElementById('salesAmount').textContent = fmt(tf[period].salesAmount);

                // period-label di header
                const labels = {
                    today: 'Hari Ini',
                    week: 'Minggu Ini',
                    month: 'Bulan Ini',
                    year: 'Tahun Ini',
                    all: 'Total'
                };
                document.getElementById('period-label').textContent = labels[period];

                // toggling tombol period di kartu
                document.querySelectorAll('.period-label').forEach(el => {
                    el.classList.toggle('hidden', el.dataset.period !== period);
                });
            }

            // klik pilihan dropdown di header
            document.querySelectorAll('.period-option').forEach(opt => {
                opt.addEventListener('click', e => {
                    e.preventDefault();
                    period = opt.dataset.period;
                    updateStats();
                    dropdownPanel.classList.add('hidden');
                });
            });

            // Inisialisasi Chart.js
            const ctx = document.getElementById('ordersChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Object.keys(tf).map(k => ({
                        today: 'Hari Ini',
                        week: 'Minggu Ini',
                        month: 'Bulan Ini',
                        year: 'Tahun Ini',
                        all: 'Total'
                    })[k]),
                    datasets: [{
                        label: 'Pesanan',
                        data: Object.values(tf).map(v => v.ordersCount),
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Tombol timeframe di bawah chart
            document.querySelectorAll('.timeframe-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.timeframe-btn').forEach(b => {
                        b.classList.replace('bg-blue-100', 'bg-gray-100');
                        b.classList.replace('text-blue-600', 'text-gray-600');
                    });
                    btn.classList.replace('bg-gray-100', 'bg-blue-100');
                    btn.classList.replace('text-gray-600', 'text-blue-600');

                    // update data chart sesuai periode
                    period = btn.dataset.period;
                    chart.data.datasets[0].data = Object.entries(tf)
                        .filter(([k]) => k === period)
                        .map(([k, v]) => v.ordersCount);
                    chart.data.labels = [({
                        today: 'Hari Ini',
                        week: 'Minggu Ini',
                        month: 'Bulan Ini',
                        year: 'Tahun Ini',
                        all: 'Total'
                    })[period]];
                    chart.update();
                });
            });

            // init
            updateStats();
        });
    </script>
@endpush
