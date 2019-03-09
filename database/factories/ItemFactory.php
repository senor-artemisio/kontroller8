<?php

use Faker\Generator as Faker;

$factory->define(\App\Api\Models\Item::class, function (Faker $faker) {
    return [
        'id' => Ulid::generate(),
        'title' => $faker->words(2, true),
        'protein' => $faker->randomFloat(2, 0, 100),
        'fat' => $faker->randomFloat(2, 0, 100),
        'carbohydrates' => $faker->randomFloat(2, 0, 100),
        'fiber' => $faker->randomFloat(2, 0, 100),
        'user_id' => Ulid::generate()
    ];
});