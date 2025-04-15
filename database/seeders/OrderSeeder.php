<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $this->command->info("🌱 Seeding orders and order items...");

        // Disable foreign key constraints temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Order::truncate();
        OrderItem::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Get all users and products
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->error('Cannot seed orders - no users or products found!');
            return;
        }

        $paymentMethods = ['transfer', 'cod', 'credit_card'];
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];

        foreach ($users as $user) {
            $ordersCount = rand(1, 5); // Each user will have 1-5 orders

            for ($i = 0; $i < $ordersCount; $i++) {
                // Create the order
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => 0, // Will be calculated from items
                    'status' => $statuses[array_rand($statuses)],
                    'shipping_address' => $this->generateAddress($user),
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'created_at' => now()->subDays(rand(0, 30)), // Random date in last 30 days
                ]);

                // Add 1-5 random products to the order
                $itemsCount = rand(1, 5);
                $selectedProducts = $products->random($itemsCount);
                $totalPrice = 0;

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);

                    $totalPrice += $price * $quantity;
                }

                // Update order total
                $order->update(['total_price' => $totalPrice]);

                $this->command->line("<fg=green>✓</> Added order ID: <fg=yellow>{$order->id}</> for user: {$user->email} with {$itemsCount} items (Total: Rp " . number_format($totalPrice, 0) . ")");
            }
        }

        $this->command->info("✅ Order seeding completed successfully!");
    }

    /**
     * Generate a fake shipping address
     */
    protected function generateAddress($user)
    {
        $streets = ['Jl. Merdeka', 'Jl. Sudirman', 'Jl. Thamrin', 'Jl. Gatot Subroto', 'Jl. Hayam Wuruk'];
        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Makassar'];

        return sprintf(
            "%s No. %d, %s, %s %s",
            $streets[array_rand($streets)],
            rand(1, 100),
            $user->name . "'s House",
            $cities[array_rand($cities)],
            rand(10000, 99999)
        );
    }
}
