<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $this->command->info("🌱 Seeding orders...");

        // Ambil semua user dari database
        $users = User::all();

        // Loop untuk membuat beberapa order
        foreach ($users as $user) {
            $ordersCount = rand(1, 5); // Setiap user bisa punya 1-5 order

            for ($i = 0; $i < $ordersCount; $i++) {
                $totalPrice = rand(100, 1000); // Harga total random

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $totalPrice,
                ]);

                $this->command->line("<fg=green>✓</> Added order ID: <fg=yellow>{$order->id}</> for user: {$user->email}");
            }
        }

        $this->command->info("✅ Order seeding completed successfully!");
    }
}
