<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->paginate(12);

        return view('categories.show', [
            'category' => $category,
            'products' => $products
        ]);
    }
}
