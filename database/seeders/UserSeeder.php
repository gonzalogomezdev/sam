<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 400) as $index) {
            User::create([
                'Email' => $faker->unique()->safeEmail,
                'Password' => $faker->password, // El password será cifrado en el modelo User
                'Token' => $faker->uuid,
                'Email_verified' => $index === 36 ? 0 : 1
            ]);
        }
    }
}