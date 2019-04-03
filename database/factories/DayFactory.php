<?php

use Faker\Generator as Faker;

$factory->define(\App\Api\Models\Day::class, function (Faker $faker) {
    return [
        'id' => Ulid::generate(),
        'protein' => $faker->randomFloat(1, 0, 200),
        'fat' => $faker->randomFloat(1, 0, 200),
        'carbohydrates' => $faker->randomFloat(1, 0, 200),
        'fiber' => $faker->randomFloat(1, 0, 200),
        'weight' => $faker->numberBetween(1, 500),
        'weight_eaten' => $faker->numberBetween(1, 500),
        'user_id' => Ulid::generate(),
        'date' => \Illuminate\Support\Carbon::now()->format('Y-m-d')
    ];
});