<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\User;
use App\Models\Product;

class RatingSeeder extends Seeder
{
    public function run()
    {
        $this->command->info("🌱 Seeding ratings...");

        // Ambil semua user dan produk dari database
        $users = User::all();
        $products = Product::all();

        foreach ($users as $user) {
            $ratedProducts = $products->random(rand(1, 5)); // Setiap user memberi rating ke 1-5 produk

            foreach ($ratedProducts as $product) {
                $ratingValue = rand(1, 5); // Rating random antara 1-5

                Rating::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rating' => $ratingValue,
                ]);

                $this->command->line("<fg=green>✓</> Added rating for product ID: <fg=yellow>{$product->id}</> by user: {$user->email}");
            }
        }

        $this->command->info("✅ Rating seeding completed successfully!");
    }
}
