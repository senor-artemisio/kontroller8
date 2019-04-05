<?php

use App\Api\Models\DayMeal;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(DayMeal::class, function (Faker $faker) {
    return [
        'id' => Ulid::generate(),
        'day_id' => Ulid::generate(),
        'protein' => $faker->numberBetween(0, 200),
        'fat' => $faker->numberBetween(0, 200),
        'carbohydrates' => $faker->numberBetween(0, 200),
        'fiber' => $faker->numberBetween(0, 200),
        'weight' => $faker->numberBetween(1, 500),
        'eaten' => $faker->boolean,
        'user_id' => Ulid::generate(),
        'time_plan' => $faker->time(),
        'time_eaten' => $faker->time(),
    ];
});