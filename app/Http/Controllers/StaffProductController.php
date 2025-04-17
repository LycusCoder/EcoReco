<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StaffProductController extends Controller
{
    public function index()
    {
        // Dummy fallback jika kamu belum implementasi statistik harian
        $dailyStats = [
            'products' => Product::whereDate('created_at', today())->count(),
            'orders' => Order::whereDate('created_at', today())->count(),
        ];

        $newProductsCount = $dailyStats['products'] ?? 0;
        $newOrdersCount = $dailyStats['orders'] ?? 0;

        $monthlySales = Order::where('status', 'completed')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total_price');

        $totalProducts = Cache::remember('total_products', 3600, function () {
            return Product::count();
        });

        $monthlyProducts = Cache::remember('monthly_products', 3600, function () {
            return Product::whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])->count();
        });

        // Ambil produk dan generate image_url
        $products = Product::with('category')->latest()->paginate(10);

        $products->getCollection()->transform(function ($product) {
            $image = $product->image;

            if (
                !$image ||
                Str::startsWith($image, 'https://example.com')
            ) {
                $imageUrl = asset('/default_product.png');
            } elseif (Str::startsWith($image, ['http://', 'https://'])) {
                $imageUrl = $image;
            } else {
                $imageUrl = asset('storage/' . $image);
            }

            Log::debug("Image: {$image} → URL: {$imageUrl}");
            $product->image_url = $imageUrl;
            return $product;
        });


        foreach ($products as $p) {
            logger("Image: " . $p->image . " → URL: " . $p->image_url);
        }

        return view('dashboard.staff.products.index', compact(
            'products',
            'totalProducts',
            'newProductsCount',
            'newOrdersCount',
            'monthlySales',
            'monthlyProducts'
        ));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.staff.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi & simpan produk baru (lengkapi sesuai kebutuhan)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Product::create($validated);

        return redirect()->route('staff.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.staff.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Validasi & update produk (lengkapi sesuai kebutuhan)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $product->update($validated);

        return redirect()->route('staff.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('staff.products.index')
                         ->with('success', 'Produk berhasil dihapus');
    }
}
