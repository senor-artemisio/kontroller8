<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for day entity.
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