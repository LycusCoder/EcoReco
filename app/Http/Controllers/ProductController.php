<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\AprioriService;
use App\Services\CollaborativeFilteringService;

class ProductController extends Controller
{
    public function show($slug)
    {
        // Ambil produk berdasarkan slug
        $product = Product::with(['ratings', 'category'])->where('slug', $slug)->firstOrFail();

        // Rekomendasi Apriori
        $transactions = $this->getTransactionData();
        $apriori = new AprioriService($transactions);
        $aprioriRecommendations = $this->getAprioriRecommendations($apriori, $product->id);

        // Rekomendasi Collaborative Filtering
        $cfRecommendations = [];
        if (auth()->check()) {
            $ratings = Rating::all();
            $cf = new CollaborativeFilteringService($ratings);
            $cfRecommendations = $cf->getRecommendedProducts(auth()->id());
        }

        // Gabungkan rekomendasi
        $recommendedProducts = $this->combineRecommendations(
            $aprioriRecommendations,
            $cfRecommendations,
            $product->id
        );

        // Ambil produk terkait
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id)
                                ->limit(4)
                                ->get();

        // Kirim data ke view
        return view('products.show', [
            'product' => $product,
            'recommendedProducts' => $recommendedProducts,
            'relatedProducts' => $relatedProducts
        ]);
    }

    private function getTransactionData()
    {
        // Ambil data transaksi dari database
        return Order::with('products')
            ->completed() // Gunakan scope completed()
            ->get()
            ->map(function ($order) {
                return $order->products->pluck('id')->toArray();
            })
            ->toArray();
    }

    private function getAprioriRecommendations($apriori, $productId)
    {
        $rules = $apriori->run();
        $recommendations = [];

        foreach ($rules as $rule) {
            if (in_array($productId, $rule['antecedent'])) {
                $recommendations = array_merge($recommendations, $rule['consequent']);
            }
        }

        return array_unique($recommendations);
    }

    private function combineRecommendations(...$recommendations)
    {
        $merged = collect($recommendations)
            ->flatten()
            ->unique()
            ->shuffle()
            ->take(8); // Ambil 8 rekomendasi

        return Product::whereIn('id', $merged)
            ->with('category')
            ->get();
    }
}
