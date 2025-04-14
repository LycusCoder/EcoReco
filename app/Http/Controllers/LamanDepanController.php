<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Recommendation;


class LamanDepanController extends Controller
{
    /**
     * Menampilkan halaman depan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua kategori (untuk modal)
        $allCategories = \App\Models\Category::all();

        // Mengambil kategori untuk tampilan awal (8 untuk mobile, 16 untuk desktop)
        $displayCategories = \App\Models\Category::take(16)->get();

        // Mengambil semua produk
        $products = \App\Models\Product::all();

        // Mengambil semua testimonial
        $testimonials = \App\Models\Testimonial::all();

        // Menambah gambar dinamis ke setiap testimonial
        foreach ($testimonials as $testimonial) {
            $testimonial->image = "https://i.pravatar.cc/150?img=" . ($testimonial->user_id ?? random_int(1, 999));
        }

        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            // Pengguna sudah login, gunakan rekomendasi berdasarkan algoritma
            $recommendedProducts = $this->getRecommendedProductsForLoggedInUser();
        } else {
            // Pengguna belum login, gunakan produk paling banyak dibeli
            $recommendedProducts = $this->getMostBoughtProducts();
        }

        // Kirim data ke view
        return view('lamandepan.index', [
            'allCategories' => $allCategories,
            'displayCategories' => $displayCategories,
            'products' => $products,
            'recommendedProducts' => $recommendedProducts,
            'testimonials' => $testimonials,
        ]);
    }

    /**
     * Mendapatkan produk paling banyak dibeli.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getMostBoughtProducts()
    {
        // Menghitung total pembelian setiap produk
        $mostBoughtProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(3)
            ->pluck('product_id');

        // Mengambil detail produk berdasarkan ID
        return Product::whereIn('id', $mostBoughtProducts)->get();
    }

    /**
     * Mendapatkan rekomendasi produk untuk pengguna yang sudah login.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRecommendedProductsForLoggedInUser()
    {
        // Mengambil ID pengguna saat ini
        $userId = Auth::id();

        // Mengambil rekomendasi berdasarkan skor tertinggi
        $recommendedProducts = Recommendation::where('user_id', $userId)
            ->orderByDesc('score')
            ->limit(3)
            ->pluck('product_id');

        // Mengambil detail produk berdasarkan ID
        return Product::whereIn('id', $recommendedProducts)->get();
    }


    /**
     * Menampilkan halaman testimonial.
     *
     * @return \Illuminate\View\View
     */
    public function testimonials()
    {
         // Mengambil semua kategori (untuk modal)
        $allCategories = \App\Models\Category::all();

        // Mengambil kategori untuk tampilan awal (8 untuk mobile, 16 untuk desktop)
        $displayCategories = \App\Models\Category::take(16)->get();


        // Mengambil semua produk
        $products = \App\Models\Product::all();

        // Mengambil 3 produk rekomendasi pertama
        $recommendedProducts = \App\Models\Product::take(3)->get();

        // Mengambil semua testimonial
        $testimonials = \App\Models\Testimonial::all();

        // Menambah gambar dinamis ke setiap testimonial
        foreach ($testimonials as $testimonial) {
            $testimonial->image = "https://i.pravatar.cc/150?img=" . ($testimonial->user_id ?? random_int(1, 999));
        }

        // Kirim data ke view
        return view('lamandepan.index', [
            'allCategories' => $allCategories,
            'displayCategories' => $displayCategories,
            'products' => $products,
            'recommendedProducts' => $recommendedProducts,
            'testimonials' => $testimonials,
        ]);
    }
}
