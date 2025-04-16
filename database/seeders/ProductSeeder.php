<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    private $categoryCache = [];

    public function run()
    {
        $this->command->info("🌱 Seeding products...");

        $filePath = base_path('database/seeders/data/products.json');
        $jsonData = file_get_contents($filePath);
        $products = json_decode($jsonData, true);

        foreach ($products as $product) {
            $categoryId = $this->getOrCreateCategoryId($product['category']);

            $description = $product['description']
                ?? $this->fallbackDescription($product['name']);

            // Translate and generate unique slug
            $translatedName = $this->translateToIndonesian($product['name']);
            $slug = $this->generateUniqueSlug($translatedName);

            Product::create([
                'category_id' => $categoryId,
                'name' => $product['name'],
                'slug' => $slug,
                'description' => $description,
                'price' => $product['price'],
                'image' => $product['image'],
                'stock' => $product['stock'] ?? rand(1, 999),
                'rating' => $product['rating'] ?? 0.0,
                'is_active' => true,
            ]);

            $this->command->line("<fg=green>✓</> Added product: <fg=yellow>{$product['name']}</> (slug: <fg=cyan>{$slug}</>)");
        }

        $this->command->info("✅ Product seeding completed successfully!");
    }

    private function getOrCreateCategoryId($categoryName)
    {
        // Cek cache dulu
        if (isset($this->categoryCache[$categoryName])) {
            return $this->categoryCache[$categoryName];
        }

        // Cek database
        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            [
                'slug' => Str::slug($categoryName),
                'icon' => '/assets/icons/default.png',
                'is_active' => true,
            ]
        );

        // Simpan ke cache
        if ($category->wasRecentlyCreated) {
            $this->command->info("➕ Created new category: <fg=yellow>{$categoryName}</>");
        }

        $this->categoryCache[$categoryName] = $category->id;
        return $category->id;
    }

    private function generateUniqueSlug($name)
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $i = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }

    private function fallbackDescription($productName)
    {
        $filePath = base_path('database/seeders/data/deskripsi_template.json');
        $templates = json_decode(file_get_contents($filePath), true);

        if (!$templates || !is_array($templates)) {
            return "Deskripsi untuk {$productName} belum tersedia.";
        }

        $template = $templates[array_rand($templates)];
        return str_replace('{productName}', $productName, $template);
    }

    private function translateToIndonesian($name)
    {
        $filePath = base_path('database/seeders/data/indonesia/translation_dictionary.json');

        if (!file_exists($filePath)) {
            $this->command->warn("⚠️ Translation dictionary not found. Using original name.");
            return $name;
        }

        $dictionary = json_decode(file_get_contents($filePath), true);

        if (!is_array($dictionary)) {
            $this->command->warn("⚠️ Translation dictionary is invalid. Using original name.");
            return $name;
        }

        foreach ($dictionary as $english => $indo) {
            if (stripos($name, $english) !== false) {
                return str_ireplace($english, $indo, $name);
            }
        }

        return $name;
    }
}
