<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Testimonial;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Cache;

class StaffDashboardController extends Controller
{
    public function index(DashboardService $dashboardService)
    {
        // Data Statistik Harian (Dengan Cache)
        $dailyStats = Cache::remember('staff_daily_stats', 3600, function () {
            return [
                'products' => Product::whereDate('created_at', today())->count(),
                'orders' => Order::whereDate('created_at', today())->count(),
                'testimonials' => Testimonial::whereDate('created_at', today())->count(),
            ];
        });

        // Ambil jumlah produk baru dan pesanan baru hari ini
        $newProductsCount = $dailyStats['products'] ?? 0;
        $newOrdersCount = $dailyStats['orders'] ?? 0;

        // Hitung total penjualan bulan ini
        $monthlySales = Order::where('status', 'completed')
        ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
        ->sum('total_price');

        // Data Berdasarkan Rentang Waktu (Menggunakan Service)
        $timeFrameData = $dashboardService->getTimeFrameData();

        // Total Produk dan Produk Bulanan
        $totalProducts = Cache::remember('total_products', 3600, function () {
            return Product::count();
        });

        $monthlyProducts = Cache::remember('monthly_products', 3600, function () {
            return Product::whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])->count();
        });

        // Data Terbaru untuk Tabel
        $recentData = [
            'orders' => Order::with(['user:id,name,email'])
                ->select('id', 'user_id', 'status', 'created_at')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
            'products' => Product::with(['category:id,name'])
                ->select('id', 'name', 'category_id', 'created_at')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
            'testimonials' => Testimonial::with(['user:id,name,email'])
                ->select('id', 'user_id', 'rating', 'comment', 'created_at')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
        ];

        return view('dashboard.staff.index', compact(
            'totalProducts',
            'monthlyProducts',
            'dailyStats',
            'timeFrameData',
            'newProductsCount',
            'newOrdersCount',
            'monthlySales',
            'recentData'
        ));
    }
}
