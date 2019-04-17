<?php

use App\Api\Models\Meal;
use App\Api\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Meal::class, function (Faker $faker) {

    $protein = $faker->randomFloat(1, 0, 33);
    $fat = $faker->randomFloat(1, 0, 33);
    $carbohydrates = $faker->randomFloat(1, 0, 33);

    return [
        'id' => Ulid::generate(),
        'title' => $faker->words(2, true),
        'protein' => $protein,
        'fat' => $fat,
        'carbohydrates' => $carbohydrates,
        'calories' => ceil($protein * 4 + $fat * 8 + $carbohydrates * 4),
        'fiber' => $faker->randomFloat(1, 0, 100),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});