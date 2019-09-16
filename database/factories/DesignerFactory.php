<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Designer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Designer::class, function (Faker $faker) {
    $password = bcrypt('123456');
    return [
        'name' => $faker->name,
        'avatar' => $faker->imageUrl(),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'gender' => 'male',
        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'password' => $password, // 123456
        'remember_token' => Str::random(10),
        'phone' => $faker->unique()->phoneNumber,
    ];
});
