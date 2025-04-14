<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed kategori terlebih dahulu
        $this->call(CategorySeeder::class);

        // Seed pengguna
        $this->call(UserSeeder::class);

        // Seed produk setelah kategori
        $this->call(ProductSeeder::class);

        // Seed testimonial
        $this->call(TestimonialSeeder::class);


        // Seed transaksi
        $this->call(OrderSeeder::class);
        $this->call(OrderItemSeeder::class);
        $this->call(RatingSeeder::class);
        $this->call(RecommendationSeeder::class);
    }
}
