<div class="px-6 py-4">
    <!-- Stats Card -->
    <div id="stats-dashboard" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8"
        data-timeframe='@json($timeFrameData)'>

        {{-- Dropdown Filter --}}
        <div class="col-span-full flex justify-end mb-4">
            <div class="relative inline-block text-left">
                <button id="dropdown-button"
                    class="flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium">
                    <span id="period-label">Hari Ini</span>
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="dropdown-panel"
                    class="hidden absolute right-0 mt-2 w-40 bg-white divide-y divide-gray-100 rounded-md shadow-lg z-50">
                    <div class="py-1">
                        @foreach (['today' => 'Hari Ini', 'week' => '7 Hari Terakhir', 'month' => 'Bulan Ini', 'year' => 'Tahun Ini', 'all' => 'Total'] as $key => $lbl)
                            <a href="#"
                                class="period-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                data-period="{{ $key }}">{{ $lbl }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Cards --}}
        @foreach ([['title' => 'Produk Baru', 'icon' => 'fa-boxes', 'color' => 'green', 'key' => 'productsCount'], ['title' => 'Pesanan Baru', 'icon' => 'fa-shopping-cart', 'color' => 'blue', 'key' => 'ordersCount'], ['title' => 'Penjualan', 'icon' => 'fa-chart-line', 'color' => 'purple', 'key' => 'salesAmount']] as $card)
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $card['title'] }}</h3>
                        <p id="{{ $card['key'] }}" class="text-2xl font-bold text-{{ $card['color'] }}-600 mt-2">0</p>
                    </div>
                    <div class="bg-{{ $card['color'] }}-100 p-4 rounded-full">
                        <i class="fas {{ $card['icon'] }} text-{{ $card['color'] }}-600 text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-{{ $card['color'] }}-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    @foreach (['today' => '+N% hari ini', 'week' => '+N% minggu', 'month' => '+N% bulan', 'year' => '+N% tahun', 'all' => 'Total kumulatif'] as $p => $lbl)
                        <span class="period-label hidden" data-period="{{ $p }}">{{ $lbl }}</span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dash = document.getElementById('stats-dashboard');
        const tf = JSON.parse(dash.dataset.timeframe);
        let state = { period: 'today' };

        const formatCurrency = amt =>
            new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amt);

        function update() {
            document.getElementById('productsCount').textContent = tf[state.period].productsCount;
            document.getElementById('ordersCount').textContent = tf[state.period].ordersCount;
            document.getElementById('salesAmount').textContent = formatCurrency(tf[state.period].salesAmount);

            // update dropdown label
            const labels = {
                today: 'Hari Ini',
                week: '7 Hari Terakhir',
                month: 'Bulan Ini',
                year: 'Tahun Ini',
                all: 'Total'
            };
            document.getElementById('period-label').textContent = labels[state.period];

            // show/hide persen label
            document.querySelectorAll('.period-label').forEach(el =>
                el.classList.toggle('hidden', el.dataset.period !== state.period)
            );
        }

        const btn = document.getElementById('dropdown-button');
        const panel = document.getElementById('dropdown-panel');
        const opts = document.querySelectorAll('.period-option');

        // prevent dropdown click from bubbling
        panel.addEventListener('click', e => e.stopPropagation());

        // toggle dropdown
        btn.addEventListener('click', e => {
            e.stopPropagation();
            panel.classList.toggle('hidden');
        });

        // hide dropdown on outside click
        document.addEventListener('click', () => panel.classList.add('hidden'));

        // option click handler
        opts.forEach(opt => {
            opt.addEventListener('click', e => {
                e.preventDefault();
                e.stopPropagation();
                state.period = opt.dataset.period;
                update();
                panel.classList.add('hidden');
            });
        });

        update();
    });
</script>
@endpush
