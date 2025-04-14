<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recommendation;
use App\Models\User;
use App\Models\Product;

class RecommendationSeeder extends Seeder
{
    public function run()
    {
        $this->command->info("🌱 Seeding recommendations...");

        // Ambil semua user dan produk dari database
        $users = User::all();
        $products = Product::all();

        foreach ($users as $user) {
            $recommendedProducts = $products->random(rand(1, 5)); // Setiap user mendapat rekomendasi 1-5 produk

            foreach ($recommendedProducts as $product) {
                $score = rand(1, 100) / 10; // Skor random antara 1.0 - 10.0

                Recommendation::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'score' => $score,
                ]);

                $this->command->line("<fg=green>✓</> Added recommendation for product ID: <fg=yellow>{$product->id}</> to user: {$user->email}");
            }
        }

        $this->command->info("✅ Recommendation seeding completed successfully!");
    }
}
