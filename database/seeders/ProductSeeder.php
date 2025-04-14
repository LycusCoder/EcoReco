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
        // Path ke file JSON
        $filePath = base_path('database/seeders/data/products.json');

        // Baca file JSON dan decode ke array
        $jsonData = file_get_contents($filePath);
        $products = json_decode($jsonData, true);

        // Tampilkan pesan awal
        $this->command->info("🌱 Seeding products...");

        // Loop melalui data produk dan masukkan ke database
        foreach ($products as $product) {
            // Cari category_id berdasarkan nama kategori
            $categoryId = $this->getCategoryId($product['category']);

            // Jika kategori tidak ditemukan, lewati produk ini
            if (!$categoryId) {
                $this->command->error("❌ Category not found for product: {$product['name']}. Skipping...");
                continue;
            }

            // Ambil deskripsi produk dari API atau fallback
            $description = $product['description']
                ?? $this->getDescriptionFromApi($product['name'])
                ?? $this->fallbackDescription($product['name']);

            // Masukkan data produk ke database
            Product::create([
                'category_id' => $categoryId,
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $description,
                'price' => $product['price'],
                'image' => $product['image'],
                'rating' => $product['rating'] ?? 0.0,
            ]);

            // Tampilkan log modern
            $this->command->line("<fg=green>✓</> Added product: <fg=yellow>{$product['name']}</>");
        }

        // Tampilkan pesan sukses
        $this->command->info("✅ Product seeding completed successfully!");
    }

    private function getCategoryId($categoryName)
    {
        $category = Category::where('name', $categoryName)->first();

        // Jika kategori tidak ditemukan, tambahkan kategori baru
        if (!$category) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'icon' => '/assets/icons/default.png',
            ]);

            $this->command->info("➕ Created new category: <fg=yellow>{$categoryName}</> (ID: {$category->id})");
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

            $this->command->warn("⚠️ No matching description found in API for: {$productName}");
            return null;
        } catch (\Exception $e) {
            $this->command->error("❌ Failed to fetch description from API for: {$productName}. Error: {$e->getMessage()}");
            return null;
        }
    }

    private function fallbackDescription($productName)
    {
        // Path ke file JSON
        $filePath = base_path('database/seeders/data/deskripsi_template.json');

        // Baca file JSON dan decode ke array
        $jsonData = file_get_contents($filePath);
        $templates = json_decode($jsonData, true);

        // Jika file JSON tidak valid atau kosong, gunakan fallback default
        if (!$templates || !is_array($templates)) {
            $this->command->warn("⚠️ Fallback templates not found. Using default description for: {$productName}");
            return "Deskripsi untuk {$productName} belum tersedia.";
        }

        // Pilih template acak
        $template = $templates[array_rand($templates)];

        // Ganti placeholder {productName} dengan nama produk
        $description = str_replace('{productName}', $productName, $template);

        $this->command->info("📄 Generated fallback description for: <fg=yellow>{$productName}</>");
        return $description;
    }
}
