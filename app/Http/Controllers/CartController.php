<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cartItems as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total_price' => $product->price * $item['quantity']
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'cart_count' => $this->getCartCount(),
            'message' => 'Produk berhasil ditambahkan ke keranjang'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Keranjang berhasil diperbarui');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    protected function getCartCount()
    {
        $cart = session()->get('cart', []);
        return array_reduce($cart, function($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }
    public static function getCartCountStatic()
    {
        $cart = session()->get('cart', []);
        return array_reduce($cart, function($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }
}
