<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Meal is basic nutrition element, contains info about meal nutrition attributes.
 *
 * @property string $id
 * @property string $title
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $fiber
 * @property string $user_id
 * @property string $type
 * @property string|Carbon $created_at
 * @property string|Carbon $updated_at
 */
class Meal extends Model
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->timestamps = true;
        $this->incrementing = false;
        $this->table = 'meals';
        $this->fillable = [
            'id',
            'title',
            'protein',
            'fat',
            'carbohydrates',
            'fiber',
            'user_id'
        ];
        $this->casts = [
            'id' => 'string',
            'title' => 'string',
            'protein' => 'float',
            'fat' => 'float',
            'carbohydrates' => 'float',
            'fiber' => 'float',
            'user_id' => 'string'
        ];

        parent::__construct($attributes);
    }

    /**
     * Get meal type, depends from dominant component.
     *
     * @return string
     */
    public function getTypeAttribute(): ?string
    {
        if ($this->protein === $this->fat && $this->protein === $this->carbohydrates) {
            return null;
        }

        $max = max($this->protein, $this->fat, $this->carbohydrates);

        switch ($max) {
            case $this->protein:
                return 'protein';
            case $this->carbohydrates:
                return 'carbohydrates';
            case $this->fat:
                return 'fat';
        }

        return null;
    }
}