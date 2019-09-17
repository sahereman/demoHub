<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Demo;
use Faker\Generator as Faker;

$factory->define(Demo::class, function (Faker $faker) {
    return [
        'designer_id' => 1,
        'client_id' => 1,
        'name' => 'DEMO - ' . $faker->company,
        'description' => 'DEMO - ' . $faker->sentence,
        'content' => 'DEMO - ' . $faker->sentences(3, true),
        'photos' => [asset('defaults/default_demo.jpeg')],
        'is_index' => true,
        'sort' => 9,
    ];
});
