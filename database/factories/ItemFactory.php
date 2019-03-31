<?php

use Faker\Generator as Faker;

$factory->define(\App\Api\Models\Item::class, function (Faker $faker) {

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