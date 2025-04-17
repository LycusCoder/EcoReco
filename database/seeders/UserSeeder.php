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
    protected $indonesianNames = [];

    public function run()
    {
        // Load data dari JSON
        $this->locations = $this->loadJson('cities.json');
        $this->streets = $this->loadJson('streets.json');
        $this->phonePrefixes = $this->loadJson('phone_prefixes.json');
        $this->indonesianNames = $this->loadJson('nama_lokal.json');

        // Seed dari users.json
        $this->seedFromJson();

        // Seed tambahan dari factory
        $this->seedFromFactory(1000); // user tambahan

        $this->command->info("✅ User seeding completed successfully!");
    }

    protected function seedFromJson()
    {
        $filePath = base_path('database/seeders/data/users.json');
        $jsonData = file_get_contents($filePath);
        $users = json_decode($jsonData, true);

        $this->command->info("🌱 Seeding users from JSON...");

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
    }

    protected function seedFromFactory($count)
    {
        $this->command->info("🌱 Seeding {$count} additional users from factory...");

        $emailDomains = [
            '@gmail.com',
            '@yahoo.com',
            '@outlook.com',
            '@aol.com',
            '@protonmail.com',
            '@zoho.com',
            '@icloud.com',
            '@gmx.com',
            '@yandex.com',
            '@mail.com',
            '@email.id',
            '@web.id',
            '@co.id',
            '@or.id',
            '@ac.id',
            '@sch.id',
            '@my.id',
            '@biz.id',
            '@ponpes.id',
            '@go.id',
        ];

        for ($i = 0; $i < $count; $i++) {
            $name = $this->indonesianNames[array_rand($this->indonesianNames)];
            $attempts = 0;
            $maxAttempts = 5;
            $created = false;

            while (!$created && $attempts < $maxAttempts) {
                try {
                    // Generate email dari nama
                    $nameParts = explode(' ', strtolower($name));
                    $firstNamePart = $this->slugify($nameParts[0]);
                    $lastNamePart = count($nameParts) > 1 ? substr($this->slugify($nameParts[1]), 0, 5) : '';

                    // Tambahkan random number untuk memastikan unik
                    $randomSuffix = rand(1, 999);
                    $emailUsername = $firstNamePart . ($lastNamePart ? '.' . $lastNamePart : '') . $randomSuffix;

                    // Pilih domain random
                    $domain = $emailDomains[array_rand($emailDomains)];
                    $email = $emailUsername . $domain;

                    // Generate password dari nama + angka random
                    $password = $this->slugify(explode(' ', $name)[0]) . rand(100, 9999);

                    $address = $this->generateIndonesianAddress();
                    $phone = $this->generateIndonesianPhone();

                    User::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($password),
                        'preferences' => [
                            'theme' => rand(0, 1) ? 'light' : 'dark',
                            'notifications' => (bool)rand(0, 1),
                        ],
                        'email_verified_at' => now(),
                        'address' => $address,
                        'phone' => $phone,
                    ]);

                    //$this->command->line("<fg=green>✓</> Added user: <fg=yellow>{$email}</> <fg=gray>({$phone})</>");
                    $created = true;
                } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                    $attempts++;
                    if ($attempts >= $maxAttempts) {
                        $this->command->error("Failed to create user after {$maxAttempts} attempts");
                    }
                }
            }
        }
    }

    protected function generateIndonesianPhone()
    {
        $prefix = $this->phonePrefixes[array_rand($this->phonePrefixes)];
        $number = $prefix;

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

    protected function slugify($text)
    {
        // Ganti spasi dengan titik dan hapus karakter khusus
        $text = preg_replace('~[^\pL\d]+~u', '.', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '.', $text);
        $text = strtolower($text);

        return $text;
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
