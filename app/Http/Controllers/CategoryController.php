<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{


    /**
     * Menampilkan kategori untuk halaman depan
     */
    public function index()
    {
        $displayCategories = Category::active()
            ->orderBy('name')
            ->take(8)
            ->get();

        $allCategories = Category::active()
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('displayCategories', 'allCategories'));
    }


    /**
     * Menampilkan produk berdasarkan kategori
     */
    public function showProductsByCategory($slug)
    {
        $category = Category::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $products = $category->products()
            ->with('category') // Eager loading
            ->active()
            ->orderBy('rating', 'desc') // Sort by rating
            ->paginate(12);

        return view('products.by-category', compact('category', 'products'));
    }

    /**
     * Handle search functionality
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::with('category')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
            })
            ->active()
            ->orderBy('rating', 'desc')
            ->paginate(12);

        return view('products.search-results', compact('products', 'query'));
    }
}
