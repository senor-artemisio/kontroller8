<?php

use App\Api\Models\Day;
use App\Api\Models\Meal;
use App\Api\Models\Portion;
use App\Api\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Portion::class, static function (Faker $faker) {

    return [
        'id' => Ulid::generate(),
        'weight' => $faker->numberBetween(1, 500),
        'user_id' => static function () {
            return factory(User::class)->create()->id;
        },
        'day_id' => static function (array $portion) {
            return factory(Day::class)->create(['user_id' => $portion['user_id']])->id;
        },
        'meal_id' => static function (array $portion) {
            return factory(Meal::class)->create(['user_id' => $portion['user_id']])->id;
        },
        'protein' => static function (array $portion) {
            return round(Meal::find($portion['meal_id'])->protein * $portion['weight'] / 100, 1);
        },
        'fat' => static function (array $portion) {
            return round(Meal::find($portion['meal_id'])->fat * $portion['weight'] / 100, 1);
        },
        'carbohydrates' => static function (array $portion) {
            return round(Meal::find($portion['meal_id'])->carbohydrates * $portion['weight'] / 100, 1);
        },
        'fiber' => static function (array $portion) {
            return round(Meal::find($portion['meal_id'])->fiber * $portion['weight'] / 100, 1);
        },
        'calories' => static function (array $portion) {
            return ceil($portion['protein'] * 4 + $portion['fat'] * 8 + $portion['carbohydrates'] * 4);
        },
        'eaten' => $faker->boolean,
        'time' => $faker->time(),
    ];
});