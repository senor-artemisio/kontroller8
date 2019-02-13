<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель для сущности «продукт»
 */
class Item extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->incrementing = false;
        $this->table = 'items';
        $this->fillable = [
            'id',
            'title',
            'protein',
            'fat',
            'carbohydrates',
            'fiber',
            'user_id'
        ];
        $this->dates = [
            'created_at',
            'updated_at'
        ];

        parent::__construct($attributes);
    }
}