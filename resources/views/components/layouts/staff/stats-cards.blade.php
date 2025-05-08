<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Card Produk Baru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Produk Baru</h3>
                <p class="text-2xl font-bold text-primary mt-2">{{ $newProductsCount }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-full">
                <i class="fas fa-boxes text-green-600 text-2xl"></i>
            </div>
        </div>
        <div class="mt-4 text-sm text-green-600">
            <i class="fas fa-arrow-up mr-1"></i> 15% dari kemarin
        </div>
    </div>

    <!-- Card Pesanan Baru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Pesanan Baru</h3>
                <p class="text-2xl font-bold text-primary mt-2">{{ $newOrdersCount }}</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-full">
                <i class="fas fa-shopping-cart text-blue-600 text-2xl"></i>
            </div>
        </div>
        <div class="mt-4 text-sm text-blue-600">
            <i class="fas fa-arrow-up mr-1"></i> 8% dari minggu lalu
        </div>
    </div>

    <!-- Card Penjualan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Penjualan</h3>
                <p class="text-2xl font-bold text-primary mt-2">Rp {{ number_format($monthlySales) }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-full">
                <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
            </div>
        </div>
        <div class="mt-4 text-sm text-purple-600">
            <i class="fas fa-arrow-up mr-1"></i> 22% dari bulan lalu
        </div>
    </div>
</div>
