<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected $locations = [];
    protected $streets = [];
    protected $phonePrefixes = [];

    public function run()
    {
        // Load lokasi, jalan, dan prefix nomor telepon dari JSON
        $this->locations = $this->loadJson('cities.json');
        $this->streets = $this->loadJson('streets.json');
        $this->phonePrefixes = $this->loadJson('phone_prefixes.json');

        // Path file users.json
        $filePath = base_path('database/seeders/data/users.json');
        $jsonData = file_get_contents($filePath);
        $users = json_decode($jsonData, true);

        $this->command->info("🌱 Seeding users...");

        foreach ($users as $user) {
            $address = $this->generateIndonesianAddress();
            $phone = $this->generateIndonesianPhone();

            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'preferences' => $user['preferences'] ?? null,
                'email_verified_at' => now(),
                'address' => $address,
                'phone' => $phone,
            ]);

            $this->command->line("<fg=green>✓</> Added user: <fg=yellow>{$user['email']}</> <fg=gray>({$phone})</>");
        }

        $this->command->info("✅ User seeding completed successfully!");
    }

    protected function generateIndonesianPhone()
    {
        $prefix = $this->phonePrefixes[array_rand($this->phonePrefixes)];
        $number = $prefix;

        // Tambahkan 7 angka acak
        for ($i = 0; $i < 7; $i++) {
            $number .= rand(0, 9);
        }

        return $number;
    }

    protected function generateIndonesianAddress()
    {
        $street = $this->streets[array_rand($this->streets)];
        $number = rand(1, 200);
        $city = $this->locations[array_rand($this->locations)];

        return "$street No. $number, $city, Indonesia";
    }

    protected function loadJson($filename)
    {
        $path = base_path("database/seeders/data/indonesia/{$filename}");
        if (!file_exists($path)) {
            throw new \Exception("File not found: {$filename}");
        }

        return json_decode(file_get_contents($path), true);
    }
}
