@extends('layouts.staff')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Header with Gradient -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Staff Dashboard</h1>
                <p class="text-sm text-gray-500 mt-2">
                    <i class="fas fa-clock mr-1"></i> Last Update: {{ now()->format('d M Y H:i') }}
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="relative inline-block text-left">
                    <button id="dropdown-button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span id="period-label">Hari Ini</span>
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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

    <!-- Summary Cards with Hover Effects -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
        @php
            $summaryCards = [
                ['title' => 'Total Pesanan', 'value' => $timeFrameData['all']['ordersCount'], 'icon' => 'fa-shopping-cart', 'color' => 'bg-blue-100 text-blue-600'],
                ['title' => 'Total Produk', 'value' => $timeFrameData['all']['productsCount'], 'icon' => 'fa-boxes', 'color' => 'bg-purple-100 text-purple-600'],
                ['title' => 'Total Penjualan', 'value' => 'Rp ' . number_format($timeFrameData['all']['salesAmount'], 0, ',', '.'), 'icon' => 'fa-chart-line', 'color' => 'bg-green-100 text-green-600'],
                ['title' => 'Pesanan Bulan Ini', 'value' => $timeFrameData['month']['ordersCount'], 'icon' => 'fa-calendar-alt', 'color' => 'bg-yellow-100 text-yellow-600'],
                ['title' => 'Pendapatan Bulan Ini', 'value' => 'Rp ' . number_format($timeFrameData['month']['salesAmount'], 0, ',', '.'), 'icon' => 'fa-wallet', 'color' => 'bg-red-100 text-red-600'],
            ];
        @endphp

        @foreach($summaryCards as $card)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">{{ $card['title'] }}</p>
                        <p class="mt-2 text-2xl font-semibold text-gray-800">{{ $card['value'] }}</p>
                    </div>
                    <div class="p-3 rounded-full {{ $card['color'] }}">
                        <i class="fas {{ $card['icon'] }} text-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Timeframe Statistics Cards -->
    <div id="stats-dashboard" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" data-timeframe='@json($timeFrameData)'>
        @php
          $cards = [
            ['title'=>'Produk Baru','icon'=>'fa-box-open','color'=>'purple','key'=>'productsCount'],
            ['title'=>'Pesanan Baru','icon'=>'fa-shopping-bag','color'=>'blue','key'=>'ordersCount'],
            ['title'=>'Penjualan','icon'=>'fa-money-bill-wave','color'=>'green','key'=>'salesAmount'],
          ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $card['title'] }}</h3>
                        <p id="{{ $card['key'] }}" class="text-3xl font-bold text-{{ $card['color'] }}-600 mt-2">
                            @if($card['key'] === 'salesAmount')
                                Rp 0
                            @else
                                0
                            @endif
                        </p>
                    </div>
                    <div class="bg-{{ $card['color'] }}-100 p-4 rounded-full">
                        <i class="fas {{ $card['icon'] }} text-{{ $card['color'] }}-600 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    @foreach(['today'=>'Hari Ini','week'=>'Minggu Ini','month'=>'Bulan Ini','year'=>'Tahun Ini','all'=>'Total'] as $p=>$lbl)
                        <span class="period-label hidden text-sm text-{{ $card['color'] }}-500 bg-{{ $card['color'] }}-100 px-3 py-1 rounded-full cursor-pointer"
                              data-period="{{ $p }}"
                              onclick="setPeriod('{{ $p }}')">
                            <i class="fas fa-arrow-up mr-1"></i> {{ $lbl }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Data Section -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Aktivitas Terkini</h2>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-shopping-cart mr-2 text-blue-500"></i> Pesanan Terbaru
                    </h3>
                    <a href="#" class="text-sm text-blue-500 hover:text-blue-700">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($recentData['orders'] as $order)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">#{{ $order->id }}</p>
                                <p class="text-sm text-gray-500">{{ $order->user->name }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $order->status==='completed'?'bg-green-100 text-green-800':($order->status==='processing'?'bg-blue-100 text-blue-800':'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Products -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-boxes mr-2 text-purple-500"></i> Produk Terbaru
                    </h3>
                    <a href="#" class="text-sm text-blue-500 hover:text-blue-700">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($recentData['products'] as $product)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                            </div>
                            <span class="text-sm font-semibold {{ $product->stock>0?'text-green-600':'text-red-600' }}">
                                {{ $product->stock }} stok
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Ditambahkan {{ $product->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Testimonials -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-comment-alt mr-2 text-green-500"></i> Testimoni Terbaru
                    </h3>
                    <a href="#" class="text-sm text-blue-500 hover:text-blue-700">Lihat Semua</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($recentData['testimonials'] as $testimonial)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                                {{ substr($testimonial->user->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $testimonial->user->name }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($testimonial->message, 50) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center mt-2 text-xs text-gray-400">
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                            {{ $testimonial->rating }}/5
                            <span class="mx-2">•</span>
                            {{ $testimonial->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <!-- Quick Stats Chart -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Statistik Pesanan</h3>
            <div class="flex space-x-2">
                @foreach(['today'=>'Hari','week'=>'Minggu','month'=>'Bulan','year'=>'Tahun'] as $p=>$lbl)
                <button class="timeframe-btn px-3 py-1 text-sm rounded-full {{ $p==='week'?'bg-blue-100 text-blue-600':'bg-gray-100 text-gray-600' }}" data-period="{{ $p }}">
                    {{ $lbl }}
                </button>
                @endforeach
            </div>
        </div>
        <div class="h-64">
            <!-- Chart will be rendered here -->
            <div class="flex items-center justify-center h-full bg-gray-50 rounded-lg">
                <p class="text-gray-400">Grafik statistik akan ditampilkan di sini</p>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Dropdown functionality
    const dropdownButton = document.getElementById('dropdown-button');
    const dropdownPanel = document.getElementById('dropdown-panel');

    dropdownButton.addEventListener('click', () => {
        dropdownPanel.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdownButton.contains(e.target) && !dropdownPanel.contains(e.target)) {
            dropdownPanel.classList.add('hidden');
        }
    });

    // Timeframe statistics update
    const dash = document.getElementById('stats-dashboard');
    const tf = JSON.parse(dash.dataset.timeframe);
    let state = { period: 'today' };

    const formatCurrency = amt => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amt);
    };

    function updateStats() {
        // Update main cards
        document.getElementById('productsCount').textContent = tf[state.period].productsCount;
        document.getElementById('ordersCount').textContent = tf[state.period].ordersCount;
        document.getElementById('salesAmount').textContent = formatCurrency(tf[state.period].salesAmount);

        // Update dropdown label
        const labels = {
            'today': 'Hari Ini',
            'week': 'Minggu Ini',
            'month': 'Bulan Ini',
            'year': 'Tahun Ini',
            'all': 'Total'
        };
        document.getElementById('period-label').textContent = labels[state.period];

        // Update period labels
        document.querySelectorAll('.period-label').forEach(el => {
            el.classList.toggle('hidden', el.dataset.period !== state.period);
        });
    }

    // Period option click handler
    document.querySelectorAll('.period-option').forEach(option => {
        option.addEventListener('click', (e) => {
            e.preventDefault();
            state.period = option.dataset.period;
            updateStats();
            dropdownPanel.classList.add('hidden');
        });
    });

    // Timeframe buttons for chart
    document.querySelectorAll('.timeframe-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.timeframe-btn').forEach(b => {
                b.classList.remove('bg-blue-100', 'text-blue-600');
                b.classList.add('bg-gray-100', 'text-gray-600');
            });
            btn.classList.remove('bg-gray-100', 'text-gray-600');
            btn.classList.add('bg-blue-100', 'text-blue-600');
            // Here you would typically fetch chart data for the selected period
        });
    });

    // Initialize
    updateStats();
});
</script>
@endpush
