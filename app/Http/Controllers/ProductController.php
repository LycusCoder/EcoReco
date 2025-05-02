<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\AprioriService;
use App\Services\CollaborativeFilteringService;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['ratings', 'category'])->where('slug', $slug)->firstOrFail();

        // Rekomendasi Apriori
        $transactions = $this->getTransactionData();
        Log::info("Transaksi untuk Apriori:", ['transactions' => $transactions]);

        $apriori = new AprioriService($transactions);
        $aprioriRecommendations = $this->getAprioriRecommendations($apriori, $product->id);
        Log::info("Rekomendasi Apriori untuk produk " . $product->id, ['hasil' => $aprioriRecommendations]);

        // Rekomendasi Collaborative Filtering
        $cfRecommendations = [];
        if (auth()->check()) {
            $ratings = Rating::all();
            $cf = new CollaborativeFilteringService($ratings);
            $cfRecommendations = $cf->getRecommendedProducts(auth()->id());
            Log::info("Rekomendasi CF untuk user " . auth()->id(), ['hasil' => $cfRecommendations]);
        } else {
            Log::info("User belum login, CF tidak dijalankan");
        }

        // Gabungkan rekomendasi
        $recommendedProducts = $this->combineRecommendations(
            $aprioriRecommendations,
            $cfRecommendations,
            $product->id
        );

        Log::info("Gabungan rekomendasi:", ['hasil' => $recommendedProducts->toArray()]);

        // Ambil produk terkait
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id)
                                ->limit(4)
                                ->get();

        return view('products.show', [
            'product' => $product,
            'recommendedProducts' => $recommendedProducts,
            'relatedProducts' => $relatedProducts
        ]);
    }

    public function search(Request $request)
    {
        Log::info('Memproses pencarian produk', $request->all());

        $query = Product::query()->with('category');

        // Filter berdasarkan kata kunci pencarian
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });

            // Highlight search term in results
            session()->flash('search_term', $searchTerm);
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter rekomendasi AI (Apriori)
        if ($request->has('recommended')) {
            try {
                Log::info('Memulai rekomendasi AI');
                $transactions = $this->getTransactionData();
                Log::debug('Data transaksi:', $transactions);

                $apriori = new AprioriService($transactions);
                $recommendedIds = $this->getAprioriRecommendations($apriori, null);

                Log::info('ID rekomendasi Apriori:', $recommendedIds);

                if (!empty($recommendedIds)) {
                    $query->whereIn('id', $recommendedIds);
                }
            } catch (\Exception $e) {
                Log::error('Error rekomendasi AI: ' . $e->getMessage());
            }
        }

        // Sorting
        $query->when($request->sort, function ($q) use ($request) {
            switch ($request->sort) {
                case 'price':
                    $q->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $q->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $q->orderBy('rating', 'desc');
                    break;
                case 'newest':
                    $q->orderBy('created_at', 'desc');
                    break;
                default:
                    $q->orderBy('created_at', 'desc');
            }
        }, function ($q) {
            $q->orderBy('created_at', 'desc');
        });

        $products = $query->paginate(12);

        return view('products.search', [
            'products' => $products,
            'categories' => Category::all(),
            'searchTerm' => $request->q ?? null
        ]);
    }

    private function getTransactionData()
    {
        return Order::with('products')
            ->completed()
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
            if ($productId === null || in_array($productId, $rule['antecedent'])) {
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
            ->take(8);

        return Product::whereIn('id', $merged)
            ->with('category')
            ->get();
    }
}
