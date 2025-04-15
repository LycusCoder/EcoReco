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

        // Pastikan ada user dan produk
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->error('❌ Cannot seed orders - no users or products found!');
            return;
        }

        // Hapus data lama dengan cara aman tergantung DB driver
        if (DB::getDriverName() !== 'sqlite') {
            DB::disableForeignKeyConstraints();
            OrderItem::truncate(); // Child dulu
            Order::truncate();     // Parent
            DB::enableForeignKeyConstraints();
        } else {
            OrderItem::query()->delete(); // Aman untuk SQLite
            Order::query()->delete();
        }

        // Load data alamat dari file JSON
        $streets = $this->loadJsonArray('indonesia/streets.json');
        $cities = $this->loadJsonArray('indonesia/cities.json');

        if (empty($streets) || empty($cities)) {
            $this->command->error("❌ Streets or cities JSON file is missing or invalid.");
            return;
        }

        $paymentMethods = ['transfer', 'cod', 'credit_card'];
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];

        foreach ($users as $user) {
            $ordersCount = rand(1, 5); // 1-5 order per user

            for ($i = 0; $i < $ordersCount; $i++) {
                // Buat order
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => 0,
                    'status' => $statuses[array_rand($statuses)],
                    'shipping_address' => $this->generateAddress($user, $streets, $cities),
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);

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

                $order->update(['total_price' => $totalPrice]);

                $this->command->line(
                    "<fg=green>✓</> Order <fg=yellow>{$order->id}</> created for <fg=blue>{$user->email}</> with <fg=cyan>{$itemsCount}</> items (Total: Rp " . number_format($totalPrice, 0) . ")"
                );
            }
        }

        $this->command->info("✅ Order seeding completed successfully!");
    }

    protected function generateAddress($user, $streets, $cities)
    {
        return sprintf(
            "%s No. %d, %s, %s %s",
            $streets[array_rand($streets)],
            rand(1, 100),
            $user->name . "'s House",
            $cities[array_rand($cities)],
            rand(10000, 99999)
        );
    }

    protected function loadJsonArray($path)
    {
        $fullPath = database_path("seeders/data/{$path}");
        if (!file_exists($fullPath)) {
            return [];
        }

        $json = file_get_contents($fullPath);
        $array = json_decode($json, true);

        return is_array($array) ? $array : [];
    }
}
