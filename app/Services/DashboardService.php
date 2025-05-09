<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Order;

class DashboardService
{
    /**
     * Ambil statistik berdasarkan rentang waktu sesuai label UI:
     * today, week, month, year, all
     */
    public function getTimeFrameData(string $label): array
    {
        $now = Carbon::now();

        $start = match ($label) {
            'today' => $now->copy()->startOfDay(),
            'week'  => $now->copy()->subDays(7),
            'month' => $now->copy()->startOfMonth(),
            'year'  => $now->copy()->startOfYear(),
            'all'   => Carbon::createFromTimestamp(0),
            default => throw new \InvalidArgumentException("Invalid period: {$label}"),
        };

        $end = $now;

        return [
            'ordersCount'   => Order::whereBetween('created_at', [$start, $end])->count(),
            'productsCount' => Product::whereBetween('created_at', [$start, $end])->count(),
            'salesAmount'   => Order::whereBetween('created_at', [$start, $end])->sum('total_price'),
        ];
    }
}
