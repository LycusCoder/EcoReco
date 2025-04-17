<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        // Generate random Indonesian name
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $name = "$firstName $lastName";

        // Generate email from name
        $nameParts = explode(' ', strtolower($name));
        $firstNamePart = Str::ascii($nameParts[0]);
        $lastNamePart = count($nameParts) > 1 ? Str::ascii(substr($nameParts[1], 0, 3)) : '';
        $email = $firstNamePart . ($lastNamePart ? '.' . $lastNamePart : '') . '@nourivex.tech';

        // Generate password from name + random number
        $password = Str::slug($firstName) . rand(100, 9999);

        return [
            'name' => $name,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => bcrypt($password),
            'preferences' => [
                'theme' => $this->faker->randomElement(['light', 'dark']),
                'notifications' => $this->faker->boolean,
            ],
            'remember_token' => Str::random(10),
        ];
    }
}
