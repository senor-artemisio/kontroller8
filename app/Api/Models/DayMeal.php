<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Meal assigned to a day, can be eaten or not.
 * @property string $id
 * @property string $day_id
 * @property string $meal_id
 * @property string $user_id
 * @property string $title
 * @property integer $protein
 * @property integer $fat
 * @property integer $carbohydrates
 * @property integer $fiber
 * @property integer $weight
 * @property bool $eaten
 * @property string $time_plan
 * @property string $time_eaten
 * @property string $created_at
 * @property string $updated_at
 */
class DayMeal extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = 'day_meals';
        $this->fillable = [
            'id',
            'day_id',
            'meal_id',
            'title',
            'protein',
            'fat',
            'carbohydrates',
            'fiber',
            'weight',
            'eaten',
            'time_plan',
            'time_eaten',
            'user_id'
        ];
        $this->dates = [
            'created_at',
            'updated_at',
        ];
        $this->casts = [
            'eaten' => 'bool'
        ];
        parent::__construct($attributes);
    }
}