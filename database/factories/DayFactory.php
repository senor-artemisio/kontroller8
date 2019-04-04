<?php

use App\Api\Models\Day;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Carbon;

/** @var Factory $factory */
$factory->define(Day::class, function (Faker $faker) {
    return [
        'id' => Ulid::generate(),
        'protein' => $faker->randomFloat(1, 0, 200),
        'fat' => $faker->randomFloat(1, 0, 200),
        'carbohydrates' => $faker->randomFloat(1, 0, 200),
        'fiber' => $faker->randomFloat(1, 0, 200),
        'weight' => $faker->numberBetween(1, 500),
        'protein_eaten' => $faker->randomFloat(1, 0, 200),
        'fat_eaten' => $faker->randomFloat(1, 0, 200),
        'carbohydrates_eaten' => $faker->randomFloat(1, 0, 200),
        'fiber_eaten' => $faker->randomFloat(1, 0, 200),
        'weight_eaten' => $faker->numberBetween(1, 500),
        'user_id' => Ulid::generate(),
        'date' => Carbon::now()->format('Y-m-d')
    ];
});