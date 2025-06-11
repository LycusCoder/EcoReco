<div class="bg-white rounded-lg shadow-md overflow-hidden h-full flex flex-col">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800 flex items-center">
            <i class="fas fa-shopping-cart mr-2 text-blue-500"></i> Pesanan Terbaru
        </h3>
        <a href="{{ route('staff.orders') }}" class="text-sm text-blue-500 hover:text-blue-700 font-medium">Lihat Semua</a>
    </div>
    <div class="divide-y divide-gray-200 flex-grow">
        @forelse ($orders as $order)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">#{{ $order->id }} - {{ $order->user->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                    <span
                        class="px-2 py-1 text-xs font-semibold rounded-full
                        @switch($order->status)
                            @case('completed') bg-green-100 text-green-800 @break
                            @case('processing') bg-blue-100 text-blue-800 @break
                            @case('cancelled') bg-red-100 text-red-800 @break
                            @default bg-yellow-100 text-yellow-800
                        @endswitch">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-gray-500">
                <i class="fas fa-box-open text-2xl mb-2"></i>
                <p>Belum ada pesanan.</p>
            </div>
        @endforelse
    </div>
</div>