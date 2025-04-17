<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Order;
use App\Models\Testimonial;

class DashboardService
{
    public function getDailyStats()
    {
        return [
            'products' => Product::whereDate('created_at', today())->count(),
            'orders' => Order::whereDate('created_at', today())->count(),
            'testimonials' => Testimonial::whereDate('created_at', today())->count(),
        ];
    }

    public function getTimeFrameData()
    {
        $timeFrames = [
            '24h' => Carbon::now()->subDay(),
            '3d' => Carbon::now()->subDays(3),
            '1w' => Carbon::now()->subWeek(),
            '1m' => Carbon::now()->subMonth(),
            '6m' => Carbon::now()->subMonths(6),
            '1y' => Carbon::now()->subYear(),
        ];

        $data = [];
        foreach ($timeFrames as $key => $date) {
            $data[$key] = [
                'products' => Product::where('created_at', '>=', $date)->count(),
                'orders' => Order::where('created_at', '>=', $date)->count(),
                'completed_orders' => Order::where('status', 'completed')
                    ->where('created_at', '>=', $date)
                    ->count(),
            ];
        }

        return $data;
    }
}
