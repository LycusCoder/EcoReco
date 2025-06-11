<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Mengambil data ringkasan untuk kartu statistik.
     */
    public function getSummaryData(): array
    {
        return [
            'totalOrders'   => Order::count(),
            'totalProducts' => Product::count(),
            'totalUsers'    => User::whereNotIn('id', [1,2,3,4,5])->count(), // Menghitung user selain staff
            'monthlySales'  => Order::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('total_price'),
            'todayOrders'   => Order::whereDate('created_at', today())->count(),
        ];
    }

    /**
     * [BARU] Mengambil data aktivitas terkini untuk dashboard.
     */
    public function getRecentActivityData(): array
    {
        return [
            'orders'       => Order::with('user')->latest()->limit(5)->get(),
            'products'     => Product::with('category')->latest()->limit(5)->get(),
            'testimonials' => Testimonial::with('user')->latest()->limit(5)->get(),
        ];
    }


    /**
     * Mengambil data chart yang sudah diproses untuk Line/Bar chart.
     */
    public function getDetailedChartData(string $period = 'today'): array
    {
        return match ($period) {
            'today' => $this->getDataForToday(),
            'week'  => $this->getDataForWeek(), // Fungsi ini kita perbaiki
            'month' => $this->getDataForMonth(),
            'year'  => $this->getDataForYear(),
            default => $this->getDataForToday(),
        };
    }

    /**
     * Mengambil data untuk Pie Chart (Top 5 produk terlaris).
     */
    public function getPieChartData(): array
    {
        $topProducts = OrderItem::select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->groupBy('products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        $labels = $topProducts->pluck('name');
        $data = $topProducts->pluck('total_sold');

        return compact('labels', 'data');
    }

    private function getDataForToday(): array
    {
        $orders = Order::whereDate('created_at', today())
            ->selectRaw('strftime(\'%H\', created_at) as hour, count(*) as count')
            ->groupBy('hour')
            ->pluck('count', 'hour')
            ->all();

        $labels = [];
        $data = [];
        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $labels[] = $hour . ':00';
            $data[] = $orders[$hour] ?? 0;
        }

        return compact('labels', 'data');
    }

    /**
     * [REVISI] Menggunakan metode yang lebih aman dan database-agnostic.
     * Tidak lagi menggunakan DAYOFWEEK() yang spesifik MySQL.
     */
    private function getDataForWeek(): array
    {
        $startOfWeek = now()->startOfWeek();
        $ordersByDay = Order::whereBetween('created_at', [$startOfWeek, now()->endOfWeek()])
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->dayOfWeekIso;
            })
            ->map(function($day) {
                return count($day);
            });

        $dayMap = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'];
        $labels = array_values($dayMap);
        $data = [];
        for ($i = 1; $i <= 7; $i++) {
            $data[] = $ordersByDay[$i] ?? 0;
        }

        return compact('labels', 'data');
    }

    private function getDataForMonth(): array
    {
        $daysInMonth = now()->daysInMonth;
        $orders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->selectRaw('strftime(\'%d\', created_at) as day, count(*) as count') // Ganti DAY dengan strftime('%d')
            ->groupBy('day')
            ->pluck('count', 'day')
            ->all();

        $labels = [];
        $data = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $day = str_pad($i, 2, '0', STR_PAD_LEFT); // Pastikan format dua digit
            $labels[] = 'Tgl ' . $i;
            $data[] = $orders[$day] ?? 0; // Gunakan kunci yang sesuai dengan strftime('%d')
        }

        return compact('labels', 'data');
    }

    private function getDataForYear(): array
    {
        $orders = Order::whereYear('created_at', now()->year)
            ->selectRaw('strftime(\'%m\', created_at) as month, count(*) as count') // Ganti MONTH dengan strftime('%m')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->all();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT); // Pastikan format dua digit
            $data[] = $orders[$month] ?? 0; // Gunakan kunci yang sesuai dengan strftime('%m')
        }

        return compact('labels', 'data');
    }
}