<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mpdf\Mpdf;

class StaffOrderController extends Controller
{
    public function index()
    {
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

        $products = Product::with('category')->latest()->paginate(10);

        $products->getCollection()->transform(function ($product) {
            $image = $product->image;

            if (
                !$image ||
                Str::startsWith($image, 'https://example.com ')
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

        $orders = Order::with('user', 'orderItems.product')->latest()->paginate(10);

        return view('dashboard.staff.orders.index', compact(
            'products',
            'totalProducts',
            'newProductsCount',
            'newOrdersCount',
            'monthlySales',
            'orders',
            'monthlyProducts'
        ));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $order->update(['status' => $request->input('status')]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diubah.');
    }

    public function previewInvoice(Order $order)
    {
        $order->load('user', 'orderItems.product');

        $data = [
            'order' => $order,
            'items' => $order->orderItems,
            'user' => $order->user,
            'total_price' => $order->total_price,
            'date' => now()->format('d F Y H:i'),
        ];

        return view('dashboard.staff.orders.invoice', $data);
    }

    public function previewPDF(Order $order)
    {
        $order->load('user', 'orderItems.product');
        $data = [
            'order' => $order,
            'items' => $order->orderItems,
            'user' => $order->user,
            'total_price' => $order->total_price,
            'date' => now()->format('d F Y H:i'),
        ];

        $html = view('dashboard.staff.orders.invoice', $data)->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'DejaVuSans',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'I'), 200)
            ->header('Content-Type', 'application/pdf');
    }

    public function generatePDF(Order $order)
    {
        $order->load('user', 'orderItems.product');
        $data = [
            'order' => $order,
            'items' => $order->orderItems,
            'user' => $order->user,
            'total_price' => $order->total_price,
            'date' => now()->format('d F Y H:i'),
        ];

        $html = view('dashboard.staff.orders.invoice', $data)->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'DejaVuSans',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output("invoice-order-{$order->id}.pdf", 'D'), 200)
            ->header('Content-Type', 'application/pdf');
    }
}