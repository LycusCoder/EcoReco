<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\User;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        // Path ke file JSON
        $filePath = base_path('database/seeders/data/testimonial.json');

        // Baca file JSON dan decode ke array
        $jsonData = file_get_contents($filePath);
        $testimonials = json_decode($jsonData, true);

        // Ambil semua user dari database
        $users = User::all();

        // Tampilkan pesan awal
        $this->command->info("🌱 Seeding testimonials...");

        // Loop melalui data testimonial dan masukkan ke database
        foreach ($testimonials as $testimonial) {
            // Pilih user secara acak
            $user = $users->random();

            // Generate random number 3 digit
            $randomNumber = rand(100, 999);

            // Generate image URL sesuai format https://i.pravatar.cc/150?img={id}
            $image = "https://i.pravatar.cc/150?img=" . $user->id . $randomNumber;

            Testimonial::create([
                'user_id' => $user->id,
                'message' => $testimonial['message'],
                'image' => $image, // Gunakan URL gambar yang di-generate
            ]);

            // Tampilkan log modern
            $this->command->line("<fg=green>✓</> Added testimonial for user ID: <fg=yellow>{$user->id}</> ({$user->email})");
        }

        // Tampilkan pesan sukses
        $this->command->info("✅ Testimonial seeding completed successfully!");
    }
}
