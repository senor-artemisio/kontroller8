<?php

use App\Api\Models\Day;
use App\Api\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Day::class, static function (Faker $faker) {
    return [
        'id' => Ulid::generate(),
        'user_id' => static function () {
            return factory(User::class)->create()->id;
        },
        'protein' => 0,
        'fat' => 0,
        'carbohydrates' => 0,
        'fiber' => 0,
        'weight' => 0,
        'calories' => 0,
        'protein_eaten' => 0,
        'fat_eaten' => 0,
        'carbohydrates_eaten' => 0,
        'fiber_eaten' => 0,
        'weight_eaten' => 0,
        'calories_eaten' => 0,
        'date' => $faker->date()
    ];
});