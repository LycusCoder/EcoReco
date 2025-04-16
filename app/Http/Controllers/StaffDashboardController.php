<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Testimonial;

class StaffDashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $completedOrders = Order::completed()->count();
        $totalCategories = Category::count();
        $totalTestimonials = Testimonial::count();

        // Kirim data ke view
        return view('dashboard.staff.index', compact(
            'totalProducts',
            'totalOrders',
            'completedOrders',
            'totalCategories',
            'totalTestimonials'
        ));
    }
}
