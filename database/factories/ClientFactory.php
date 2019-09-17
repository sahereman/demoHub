<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        // 'avatar' => $faker->imageUrl(),
        'avatar' => asset('defaults/default_avatar.jpeg'),
        'email' => $faker->unique()->safeEmail,
        'gender' => 'male',
        'phone' => $faker->unique()->phoneNumber,
    ];
});
