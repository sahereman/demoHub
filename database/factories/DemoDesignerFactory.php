<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DemoDesigner;
use Faker\Generator as Faker;

$factory->define(DemoDesigner::class, function (Faker $faker) {
    return [
        // 'demo_id' => 1,
        'admin_user_id' => 2,
    ];
});
