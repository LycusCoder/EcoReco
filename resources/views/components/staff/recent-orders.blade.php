{{-- resources/views/components/staff/recent-orders.blade.php --}}
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800 flex items-center">
            <i class="fas fa-shopping-cart mr-2 text-blue-500"></i> Pesanan Terbaru
        </h3>
        <a href="{{ route('staff.orders') }}" class="text-sm text-blue-500 hover:text-blue-700">Lihat Semua</a>
    </div>
    <div class="divide-y divide-gray-200">
        @foreach ($orders as $order)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">#{{ $order->id }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->name }}</p>
                    </div>
                    <span
                        class="px-2 py-1 text-xs font-semibold rounded-full
              {{ $order->status === 'completed'
                  ? 'bg-green-100 text-green-800'
                  : ($order->status === 'processing'
                      ? 'bg-blue-100 text-blue-800'
                      : 'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <p class="text-xs text-gray-400 mt-2">{{ $order->created_at->diffForHumans() }}</p>
            </div>
        @endforeach
    </div>
</div>
