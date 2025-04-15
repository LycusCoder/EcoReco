<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $this->command->info("🌱 Seeding products...");

        $filePath = base_path('database/seeders/data/products.json');
        $jsonData = file_get_contents($filePath);
        $products = json_decode($jsonData, true);

        foreach ($products as $product) {
            $categoryId = $this->getCategoryId($product['category']);
            if (!$categoryId) {
                $this->command->error("❌ Category not found for product: {$product['name']}. Skipping...");
                continue;
            }

            $description = $product['description']
                ?? $this->getDescriptionFromApi($product['name'])
                ?? $this->fallbackDescription($product['name']);

            // Translate name (optional) sebelum slug
            $translatedName = $this->translateToIndonesian($product['name']);
            $slug = Str::slug($translatedName);

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

    private function getCategoryId($categoryName)
    {
        $category = Category::where('name', $categoryName)->first();
        if (!$category) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'icon' => '/assets/icons/default.png',
                'is_active' => true,
            ]);

            $this->command->info("➕ Created new category: <fg=yellow>{$categoryName}</>");
        }

        return $category->id;
    }

    private function getDescriptionFromApi($productName)
    {
        try {
            $client = new Client();
            $response = $client->get("https://fakestoreapi.com/products");
            $data = json_decode($response->getBody(), true);

            foreach ($data as $item) {
                if (stripos($item['title'], $productName) !== false) {
                    $this->command->info("🌐 Fetched description from API for: <fg=yellow>{$productName}</>");
                    return $item['description'];
                }
            }

            return null;
        } catch (\Exception $e) {
            $this->command->error("❌ API error for {$productName}: {$e->getMessage()}");
            return null;
        }
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
