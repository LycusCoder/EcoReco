<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        $this->command->info("🌱 Seeding order items...");

        // Ambil semua order dan produk dari database
        $orders = Order::all();
        $products = Product::all();

        foreach ($orders as $order) {
            $itemsCount = rand(1, 5); // Setiap order bisa punya 1-5 item

            for ($i = 0; $i < $itemsCount; $i++) {
                $product = $products->random(); // Pilih produk secara acak
                $quantity = rand(1, 3); // Jumlah barang random
                $price = $product->price; // Harga produk saat pembelian

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $this->command->line("<fg=green>✓</> Added order item for order ID: <fg=yellow>{$order->id}</>");
            }
        }

        $this->command->info("✅ Order item seeding completed successfully!");
    }
}
