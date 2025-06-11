<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class StaffSidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Ambil data total produk dengan caching (sama seperti sebelumnya)
        $totalProducts = Cache::remember('total_products', now()->addHours(1), function () {
            return Product::count();
        });

        // Ambil data produk bulanan dengan caching
        $monthlyProducts = Cache::remember('monthly_products', now()->addHours(1), function () {
            return Product::whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year)
                          ->count();
        });

        // Kirim data ini ke view yang dituju
        $view->with('totalProducts', $totalProducts)
             ->with('monthlyProducts', $monthlyProducts);
    }
}