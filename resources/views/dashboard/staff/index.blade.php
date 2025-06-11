@extends('layouts.staff')

@section('content')
<div class="mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between p-6 bg-white rounded-xl shadow-lg">
            <div>
                <h1 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    Staff Dashboard
                </h1>
                <p class="text-sm text-gray-500 mt-2 flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    Last Update: {{ now()->format('d M Y H:i') }}
                </p>
            </div>
            <div class="mt-4 md:mt-0 relative inline-block text-left">
                <button id="export-btn" class="px-4 py-2 bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-lg hover:from-green-600 hover:to-teal-600 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-download mr-2"></i> Export
                    <i class="fas fa-chevron-down ml-2 text-xs"></i>
                </button>
                <div id="export-panel" class="hidden origin-top-right absolute right-0 mt-2 w-64 rounded-xl shadow-2xl bg-white ring-1 ring-gray-200 ring-opacity-5 z-50">
                    <div class="py-1">
                        <a href="{{ route('staff.dashboard.export', ['type' => 'orders']) }}" class="export-option flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            <i class="fas fa-shopping-cart"></i> Data Pesanan (Excel)
                        </a>
                        <a href="{{ route('staff.dashboard.export', ['type' => 'products']) }}" class="export-option flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            <i class="fas fa-boxes"></i> Data Produk (Excel)
                        </a>
                        <a href="{{ route('staff.dashboard.export', ['type' => 'users']) }}" class="export-option flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            <i class="fas fa-users"></i> Data Pengguna (Excel)
                        </a>
                        <div class="border-t border-gray-200 my-1"></div>
                        <button id="export-main-chart" class="export-option flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 w-full text-left">
                            <i class="fas fa-chart-line"></i> Statistik Pesanan (Gambar)
                        </button>
                        <button id="export-pie-chart" class="export-option flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 w-full text-left">
                            <i class="fas fa-chart-pie"></i> Top 5 Produk (Gambar)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        @include('components.staff.card-summary', ['title' => 'Total Pesanan', 'value' => $summary['totalOrders'], 'icon' => 'fa-shopping-cart', 'color' => 'blue'])
        @include('components.staff.card-summary', ['title' => 'Total Produk', 'value' => $summary['totalProducts'], 'icon' => 'fa-boxes', 'color' => 'purple'])
        @include('components.staff.card-summary', ['title' => 'Total Pengguna', 'value' => $summary['totalUsers'], 'icon' => 'fa-users', 'color' => 'yellow'])
        @include('components.staff.card-summary', ['title' => 'Pesanan Hari Ini', 'value' => $summary['todayOrders'], 'icon' => 'fa-calendar-day', 'color' => 'teal'])
        @include('components.staff.card-summary', ['title' => 'Pendapatan Bulan Ini', 'value' => $summary['monthlySales'], 'icon' => 'fa-wallet', 'color' => 'red', 'isCurrency' => true])
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 id="chart-title" class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-blue-500"></i> Statistik Pesanan Hari Ini
                </h3>
                <div class="flex items-center space-x-4 mt-3 sm:mt-0">
                    <div class="flex space-x-1 p-1 bg-gray-100 rounded-full">
                        <button class="chart-type-btn" data-type="line" title="Line Chart"><i class="fas fa-chart-line"></i></button>
                        <button class="chart-type-btn" data-type="bar" title="Bar Chart"><i class="fas fa-chart-bar"></i></button>
                    </div>
                    <div class="flex space-x-1">
                        @foreach(['today' => 'Hari', 'week' => 'Minggu', 'month' => 'Bulan', 'year' => 'Tahun'] as $p => $lbl)
                            <button class="timeframe-btn" data-period="{{ $p }}">{{ $lbl }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="relative h-80">
                <div id="chart-loader" class="absolute inset-0 bg-white/70 flex items-center justify-center z-10 hidden">
                    <i class="fas fa-spinner fa-spin text-blue-500 text-3xl"></i>
                </div>
                <canvas id="mainChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center mb-4">
                <i class="fas fa-chart-pie mr-2 text-purple-500"></i> Top 5 Produk Terlaris
            </h3>
            <div class="relative h-80">
                <div id="pie-chart-loader" class="absolute inset-0 bg-white/70 flex items-center justify-center z-10 hidden">
                    <i class="fas fa-spinner fa-spin text-purple-500 text-3xl"></i>
                </div>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
    .export-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: #4b5563;
        transition: background-color 0.2s;
    }
    .export-option:hover {
        background-color: #f3f4f6;
        color: #1f2937;
    }
    .timeframe-btn, .chart-type-btn {
        padding: 0.5rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .chart-type-btn {
        background-color: #e5e7eb;
        color: #4b5563;
    }
    .chart-type-btn.active {
        background-color: #3b82f6;
        color: white;
    }
    .timeframe-btn {
        background-color: #f3f4f6;
        color: #4b5563;
    }
    .timeframe-btn.active {
        background-color: #dbeafe;
        color: #2563eb;
        font-weight: 600;
        border-color: #bfdbfe;
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- STATE MANAGEMENT ---
        const chartState = {
            main: {
                instance: null,
                period: 'today',
                type: 'line',
                title: 'Statistik Pesanan',
            },
            pie: {
                instance: null,
            }
        };

        // --- DOM ELEMENTS ---
        const mainChartCanvas = document.getElementById('mainChart');
        const pieChartCanvas = document.getElementById('pieChart');
        const mainChartLoader = document.getElementById('chart-loader');
        const pieChartLoader = document.getElementById('pie-chart-loader');
        const chartTitle = document.getElementById('chart-title');
        const exportBtn = document.getElementById('export-btn');
        const exportPanel = document.getElementById('export-panel');

        // --- HELPER FUNCTIONS ---
        const showLoader = (loader) => loader.classList.remove('hidden');
        const hideLoader = (loader) => loader.classList.add('hidden');
        const formatCurrency = (value) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);

        // --- CHART RENDERING ---
        async function fetchAndUpdateMainChart() {
            showLoader(mainChartLoader);
            
            try {
                const response = await fetch(`{{ route('staff.dashboard.chart_data') }}?period=${chartState.main.period}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const { labels, data } = await response.json();

                if (chartState.main.instance) {
                    chartState.main.instance.destroy();
                }

                chartTitle.innerHTML = `<i class="fas fa-chart-line mr-2 text-blue-500"></i> Statistik Pesanan ${document.querySelector(`.timeframe-btn[data-period=${chartState.main.period}]`).textContent}`;

                chartState.main.instance = new Chart(mainChartCanvas, {
                    type: chartState.main.type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pesanan',
                            data: data,
                            borderColor: '#3b82f6',
                            backgroundColor: chartState.main.type === 'line' ? 'rgba(59, 130, 246, 0.1)' : '#3b82f6',
                            fill: chartState.main.type === 'line',
                            tension: 0.3,
                            borderWidth: 2,
                            pointBackgroundColor: '#3b82f6',
                            pointRadius: 3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true } },
                        plugins: { legend: { display: false } }
                    }
                });
            } catch (error) {
                console.error('Failed to fetch main chart data:', error.message);
                mainChartCanvas.getContext('2d').clearRect(0, 0, mainChartCanvas.width, mainChartCanvas.height);
                mainChartCanvas.getContext('2d').fillStyle = '#ef4444';
                mainChartCanvas.getContext('2d').fillText('Error: ' + error.message, 10, 50);
            } finally {
                hideLoader(mainChartLoader);
            }
        }

        async function fetchAndCreatePieChart() {
            showLoader(pieChartLoader);
            try {
                const response = await fetch(`{{ route('staff.dashboard.pie_chart_data') }}`);
                if (!response.ok) throw new Error('Network response was not ok');
                const { labels, data } = await response.json();

                if (chartState.pie.instance) {
                    chartState.pie.instance.destroy();
                }
                
                chartState.pie.instance = new Chart(pieChartCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Terjual',
                            data: data,
                            backgroundColor: ['#6366f1', '#8b5cf6', '#a855f7', '#d946ef', '#ec4899'],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } }
                    }
                });

            } catch(error) {
                console.error('Failed to fetch pie chart data:', error);
                pieChartCanvas.getContext('2d').fillText('Gagal memuat data', 10, 50);
            } finally {
                hideLoader(pieChartLoader);
            }
        }

        // --- EXPORT CHART FUNCTIONS ---
        function exportChartAsImage(chartInstance, fileName) {
            if (chartInstance) {
                const link = document.createElement('a');
                link.download = `${fileName}_${new Date().toISOString().split('T')[0]}.png`;
                link.href = chartInstance.toBase64Image();
                link.click();
            } else {
                alert('Chart not available for export.');
            }
        }

        // --- EVENT LISTENERS ---
        // Export Dropdown
        exportBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            exportPanel.classList.toggle('hidden');
        });
        document.addEventListener('click', () => exportPanel.classList.add('hidden'));

        // Main Chart Controls
        document.querySelectorAll('.timeframe-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelector('.timeframe-btn.active')?.classList.remove('active');
                btn.classList.add('active');
                chartState.main.period = btn.dataset.period;
                fetchAndUpdateMainChart();
            });
        });

        document.querySelectorAll('.chart-type-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelector('.chart-type-btn.active')?.classList.remove('active');
                btn.classList.add('active');
                chartState.main.type = btn.dataset.type;
                fetchAndUpdateMainChart();
            });
        });

        // Export Chart Buttons
        document.getElementById('export-main-chart').addEventListener('click', () => {
            exportChartAsImage(chartState.main.instance, 'statistik_pesanan');
        });

        document.getElementById('export-pie-chart').addEventListener('click', () => {
            exportChartAsImage(chartState.pie.instance, 'top_5_produk');
        });

        // --- INITIALIZATION ---
        document.querySelector(`.timeframe-btn[data-period='${chartState.main.period}']`).classList.add('active');
        document.querySelector(`.chart-type-btn[data-type='${chartState.main.type}']`).classList.add('active');
        fetchAndUpdateMainChart();
        fetchAndCreatePieChart();
    });
</script>
@endpush