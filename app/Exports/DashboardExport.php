<?php

namespace App\Exports;

use App\Services\DashboardService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DashboardExport implements FromArray, WithHeadings
{
    protected $period;
    protected $dashboardService;

    public function __construct(string $period, DashboardService $dashboardService)
    {
        $this->period = $period;
        $this->dashboardService = $dashboardService;
    }

    public function array(): array
    {
        $data = $this->dashboardService->getTimeFrameData($this->period);
        return [
            [
                $data['ordersCount'],
                $data['productsCount'],
                $data['salesAmount'],
            ]
        ];
    }

    public function headings(): array
    {
        return ['Total Pesanan', 'Total Produk', 'Total Penjualan'];
    }
}
