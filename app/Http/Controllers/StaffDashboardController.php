<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Testimonial;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Cache;

class StaffDashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        // 1. Time frame statistik
        $frames = ['today', 'week', 'month', 'year', 'all'];
        $timeFrameData = [];
        foreach ($frames as $frame) {
            $timeFrameData[$frame] = $this->dashboardService->getTimeFrameData($frame);
        }

        // 2. Total produk & produk bulan ini
        $totalProducts   = Cache::remember('total_products', 3600, fn() => Product::count());
        $monthlyProducts = Cache::remember('monthly_products', 3600, fn() =>
            Product::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count()
        );

        // 3. Pesanan baru untuk badge
        $newOrdersCount = $timeFrameData['today']['ordersCount'];

        // 4. Data terbaru
        $recentData = [
            'orders'       => Order::with('user')->latest()->limit(5)->get(),
            'products'     => Product::with('category')->latest()->limit(5)->get(),
            'testimonials' => Testimonial::with('user')->latest()->limit(5)->get(),
        ];

        return view('dashboard.staff.index', compact(
            'timeFrameData',
            'totalProducts',
            'monthlyProducts',
            'newOrdersCount',
            'recentData'
        ));
    }

    /**
     * AJAX endpoint (jika diperlukan)
     */
    public function getData(Request $request)
    {
        $period = $request->input('period', 'today');
        $data   = $this->dashboardService->getTimeFrameData($period);

        return response()->json([
            'ordersCount'   => $data['ordersCount'],
            'productsCount' => $data['productsCount'],
            'salesAmount'   => $data['salesAmount'],
        ]);
    }
}
