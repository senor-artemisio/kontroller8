<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Item::class, function (Faker $faker) {
    return [
        'id' => Ulid::generate(),
        'title' => $faker->title,
        'protein' => $faker->randomFloat(null, 0, 100),
        'fat' => $faker->randomFloat(null, 0, 100),
        'carbohydrates' => $faker->randomFloat(null, 0, 100),
        'fiber' => $faker->randomFloat(null, 0, 100),
        'user_id' => Ulid::generate()
    ];
});