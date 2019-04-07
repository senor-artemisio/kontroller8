<?php

namespace App\Api\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Portion is a meal assigned to a day, can be eaten or not.
 *
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
 * @property string|Carbon $created_at
 * @property string|Carbon $updated_at
 */
class Portion extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->timestamps = true;
        $this->incrementing = false;
        $this->table = 'portions';
        $this->fillable = [
            'id',
            'day_id',
            'meal_id',
            'user_id',
            'protein',
            'fat',
            'carbohydrates',
            'fiber',
            'weight',
            'eaten',
            'time_plan',
            'time_eaten',
        ];
        $this->casts = [
            'eaten' => 'bool'
        ];
        parent::__construct($attributes);
    }
}