<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        // 'demo_id' => 1,
        'name' => $faker->words(3, true),
        'sort' => 9,
    ];
});
