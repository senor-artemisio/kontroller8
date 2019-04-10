<?php

namespace App\Api\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property string|Carbon $time_plan
 * @property string|Carbon $time_eaten
 * @property string|Carbon $created_at
 * @property string|Carbon $updated_at
 * @property Meal $meal
 * @property Day $day
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
            'eaten' => 'bool',
            'time_plan' => 'time',
            'time_eaten' => 'time'
        ];
        parent::__construct($attributes);
    }

    /**
     * @return BelongsTo
     */
    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }

    /**
     * @return BelongsTo
     */
    public function day(): BelongsTo
    {
        return $this->belongsTo(Day::class);
    }
}