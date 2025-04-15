<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\User;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $filePath = base_path('database/seeders/data/testimonial.json');

        $jsonData = file_get_contents($filePath);
        $testimonials = json_decode($jsonData, true);

        $users = User::all();

        if ($users->isEmpty() || empty($testimonials)) {
            $this->command->error("❌ No users or testimonial data available.");
            return;
        }

        $this->command->info("🌱 Seeding testimonials (1 per user)...");

        // Ambil user yang belum punya testimonial
        $availableUsers = $users->reject(function ($user) {
            return Testimonial::where('user_id', $user->id)->exists();
        })->shuffle();

        $testimonialCount = min(count($testimonials), $availableUsers->count());

        for ($i = 0; $i < $testimonialCount; $i++) {
            $user = $availableUsers[$i];
            $testimonial = $testimonials[$i];

            // Bikin image URL
            $image = "https://i.pravatar.cc/150?img=" . ($user->id + rand(100, 999));

            Testimonial::create([
                'user_id' => $user->id,
                'message' => $testimonial['message'],
                'image' => $image,
            ]);

            $this->command->line("<fg=green>✓</> Testimonial added for <fg=yellow>{$user->email}</>");
        }

        $this->command->info("✅ Testimonial seeding completed!");
    }
}
