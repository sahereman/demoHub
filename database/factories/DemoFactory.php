<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Demo;
use Faker\Generator as Faker;

$factory->define(Demo::class, function (Faker $faker) {
    return [
        'scenario' => Demo::DEMO_SCENARIO_PC,
        'name' => 'DEMO - ' . $faker->company,
        'description' => 'DEMO Description - ' . $faker->sentence,
        'memo' => 'Client Name: ' . $faker->name . ', Phone Number: ' . $faker->phoneNumber,
    ];
});
