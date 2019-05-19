<?php

use App\Api\Models\Profile;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Profile::class, function (Faker $faker) {
    return [
        'user_id' => Ulid::generate(),
        'age' => $faker->numberBetween(18, 99),
        'weight' => $faker->numberBetween(30, 200),
        'height' => $faker->numberBetween(100, 250),
        'gender' => $faker->boolean,
        'modifier' => $faker->randomFloat(1, 0.8, 1.2),
        'activity' => $faker->randomFloat(3, 1.2, 1.725),
        'calories' => 2700
    ];
});