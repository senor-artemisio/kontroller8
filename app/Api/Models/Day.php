<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for day.
 *
 * @property string $id
 * @property string $date
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $fiber
 * @property float $weight
 * @property float $weight_eaten
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
            'weight_eaten',
            'user_id',
        ];

        $this->dates = [
            'created_at',
            'updated_at',
            'date'
        ];

        parent::__construct($attributes);
    }
}