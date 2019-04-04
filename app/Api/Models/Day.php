<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for day.
 *
 * @property string $id
 * @property string $date
 *
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $fiber
 * @property integer $weight
 *
 * @property float $protein_eaten
 * @property float $fat_eaten
 * @property float $carbohydrates_eaten
 * @property float $fiber_eaten
 * @property integer $weight_eaten
 *
 * @property string $user_id
 */
class Day extends Model
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->incrementing = false;
        $this->table = 'days';
        $this->fillable = [
            'id',
            'date',

            'protein',
            'fat',
            'carbohydrates',
            'fiber',
            'weight',

            'protein_eaten',
            'fat_eaten',
            'carbohydrates_eaten',
            'fiber_eaten',
            'weight_eaten',

            'user_id',
        ];

        $this->dates = [
            'created_at',
            'updated_at',
            'date'
        ];

        $this->casts = [
            'id' => 'string',

            'protein' => 'float',
            'fat' => 'float',
            'carbohydrates' => 'float',
            'fiber' => 'float',
            'weight' => 'float',

            'protein_eaten' => 'integer',
            'fat_eaten' => 'integer',
            'carbohydrates_eaten' => 'integer',
            'fiber_eaten' => 'integer',
            'weight_eaten' => 'integer',

            'user_id' => 'string',
        ];

        parent::__construct($attributes);
    }
}