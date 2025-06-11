<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Exports\OrdersExport;
use App\Exports\ProductsExport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class StaffDashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Menampilkan halaman utama dashboard staff.
     */
    public function index()
    {
        $summary = $this->dashboardService->getSummaryData();
        $recentData = $this->dashboardService->getRecentActivityData();
        return view('dashboard.staff.index', compact('summary', 'recentData'));
    }

    /**
     * Endpoint API untuk mengambil data chart time-series (Line/Bar).
     */
    public function getChartData(Request $request)
    {
        $period = $request->input('period', 'today');
        $data = $this->dashboardService->getDetailedChartData($period);
        return response()->json($data);
    }

    /**
     * Endpoint API untuk mengambil data Pie Chart.
     */
    public function getPieChartData()
    {
        $data = $this->dashboardService->getPieChartData();
        return response()->json($data);
    }

    /**
     * Menangani ekspor data ke Excel secara dinamis.
     */
    public function export(Request $request)
    {
        $type = $request->input('type', 'orders');
        $fileName = 'export_' . $type . '_' . now()->format('Ymd_His') . '.xlsx';

        $exportClass = match ($type) {
            'products' => new ProductsExport(),
            'users' => new UsersExport(),
            default => new OrdersExport(),
        };

        return Excel::download($exportClass, $fileName);
    }

    /**
     * Menangani ekspor chart sebagai gambar.
     */
    public function exportChart(Request $request)
    {
        $chartType = $request->input('type', 'main'); // 'main' untuk Statistik Pesanan, 'pie' untuk Top 5 Produk
        $period = $request->input('period', 'today'); // Periode untuk chart utama

        // Logika sederhana untuk simulasi (data dummy, karena Chart.js perlu render di client)
        return response()->json(['status' => 'success', 'type' => $chartType, 'period' => $period]);
    }
}