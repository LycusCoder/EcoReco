<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id)
                                ->limit(4)
                                ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->paginate(12);

        return view('products.search-results', [
            'products' => $products,
            'query' => $query
        ]);
    }

}
