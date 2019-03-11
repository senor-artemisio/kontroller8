<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for item entity.
 *
 * @property string $id
 * @property string $title
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $fiber
 * @property string $user_id
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 */
class Item extends Model
{
    /**
     * {@inheritdoc}
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

    /**
     * Get item type, depends from dominant component.
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