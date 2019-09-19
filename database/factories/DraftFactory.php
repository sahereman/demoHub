<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Draft;
use Faker\Generator as Faker;

$factory->define(Draft::class, function (Faker $faker) {
    return [
        // 'category_id' => 1,
        'name' => $faker->words(3, true),
        'thumb' => $faker->imageUrl(240, 240),
        'photo' => $faker->imageUrl(400, 400),
        'sort' => 9,
    ];
});
