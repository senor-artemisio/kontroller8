<?php

use App\Api\Models\Meal;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Meal::class, function (Faker $faker) {

    return [
        'id' => Ulid::generate(),
        'title' => $faker->words(2, true),
        'protein' => $faker->randomFloat(1, 0, 33),
        'fat' => $faker->randomFloat(1, 0, 33),
        'carbohydrates' => $faker->randomFloat(1, 0, 33),
        'fiber' => $faker->randomFloat(1, 0, 100),
        'user_id' => Ulid::generate()
    ];
});