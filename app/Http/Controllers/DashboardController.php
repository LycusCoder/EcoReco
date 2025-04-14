<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\Testimonial;
use App\Models\Recommendation;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil ID pengguna saat ini
        $userId = Auth::id();

        // 1. Rekomendasi Produk
        $recommendedProducts = $this->getRecommendedProducts($userId);

        // 2. Riwayat Pembelian
        $purchaseHistory = $this->getPurchaseHistory($userId);

        // 3. Testimonial Pengguna
        $userTestimonials = $this->getUserTestimonials($userId);

        // Kirim data ke view
        return view('dashboard.index', [
            'recommendedProducts' => $recommendedProducts,
            'purchaseHistory' => $purchaseHistory,
            'userTestimonials' => $userTestimonials,
        ]);
    }

    /**
     * Mendapatkan rekomendasi produk untuk pengguna tertentu.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRecommendedProducts($userId)
    {
        $recommendedProducts = Recommendation::where('user_id', $userId)
            ->orderByDesc('score')
            ->limit(3)
            ->pluck('product_id');

        return Product::whereIn('id', $recommendedProducts)->get();
    }

    /**
     * Mendapatkan riwayat pembelian pengguna.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getPurchaseHistory($userId)
    {
        return Order::where('user_id', $userId)
            ->with('orderItems.product')
            ->latest()
            ->get();
    }

    /**
     * Mendapatkan testimonial pengguna.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getUserTestimonials($userId)
    {
        return Testimonial::where('user_id', $userId)->get();
    }
}
