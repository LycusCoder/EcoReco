<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Path ke file JSON
        $filePath = base_path('database/seeders/data/category.json');

        // Baca file JSON dan decode ke array
        $jsonData = file_get_contents($filePath);
        $categories = json_decode($jsonData, true);

        // Tampilkan pesan awal
        $this->command->info("🌱 Seeding categories...");

        // Loop melalui data kategori dan masukkan ke database
        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']), // Generate slug
                'icon' => $category['icon'] ?? null, // Icon opsional
                'is_active' => true, // Semua kategori aktif
            ]);

            // Tampilkan log modern
            $this->command->line("<fg=green>✓</> Added category: <fg=yellow>{$category['name']}</>");
        }

        // Tampilkan pesan sukses
        $this->command->info("✅ Category seeding completed successfully!");
    }
}
