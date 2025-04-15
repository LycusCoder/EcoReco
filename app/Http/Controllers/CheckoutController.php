<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        $products = [];
        $total = 0;

        foreach ($cartItems as $productId => $item) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total_price' => $product->price * $item['quantity']
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        return view('checkout.index', compact('products', 'total'));
    }

    public function process(Request $request)
    {
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        // Validasi data checkout
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|in:transfer,cod,credit_card',
        ]);

        // Proses checkout
        try {
            // Buat order
            $order = Auth::user()->orders()->create([
                'total_price' => $request->total,
                'status' => 'processing', // Ubah dari 'pending' ke 'processing'
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
            ]);

            // Tambahkan order items
            foreach ($cartItems as $productId => $item) {
                $product = \App\Models\Product::find($productId);
                $order->orderItems()->create([
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            // Kosongkan cart
            session()->forget('cart');

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: #'.$order->id);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
