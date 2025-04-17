@extends('layouts.staff')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Staff Dashboard</h1>
        <div class="flex items-center space-x-4 mt-2">
            <span class="text-sm text-gray-600">Last Update: {{ now()->format('d M Y H:i') }}</span>
        </div>
    </div>

    <!-- Filter Waktu -->
    <div class="mb-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach(['24h', '3d', '1w', '1m', '6m', '1y'] as $timeFrame)
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <p class="text-xs font-semibold text-gray-500 mb-1 uppercase">{{ $timeFrame }}</p>
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $timeFrameData[$timeFrame]['orders'] }}
                    </p>
                    <span class="text-xs text-gray-500">Pesanan</span>
                </div>
                <div class="text-green-500">
                    <i class="fas fa-chart-line text-lg"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Tabel Data Terbaru -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <!-- Tabel Pesanan Terbaru -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-800">Pesanan Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentData['orders'] as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">#{{ $order->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $order->user->name }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Produk Terbaru -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-800">Produk Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentData['products'] as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $product->category->name }}</td>
                            <td class="px-4 py-3 text-sm
                                {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stock }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Testimoni Terbaru -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-800">Testimoni Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentData['testimonials'] as $testimonial)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">{{ $testimonial->user->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600 truncate max-w-xs">{{ $testimonial->message }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
