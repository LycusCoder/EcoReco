<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Path ke file JSON
        $filePath = base_path('database/seeders/data/users.json');

        // Baca file JSON dan decode ke array
        $jsonData = file_get_contents($filePath);
        $users = json_decode($jsonData, true);

        // Tampilkan pesan awal
        $this->command->info("🌱 Seeding users...");

        // Loop melalui data pengguna dan masukkan ke database
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']), // Hash password
                'preferences' => $user['preferences'] ?? null, // Preferences opsional
                'email_verified_at' => now(), // Verifikasi email langsung
            ]);

            // Tampilkan log modern
            $this->command->line("<fg=green>✓</> Added user: <fg=yellow>{$user['email']}</>");
        }

        // Tampilkan pesan sukses
        $this->command->info("✅ User seeding completed successfully!");
    }
}
