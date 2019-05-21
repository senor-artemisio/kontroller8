<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Day arrange all stats and meals for a date.
 *
 * @property string $id
 * @property string|Carbon $date
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $fiber
 * @property integer $weight
 * @property integer $calories
 * @property float $protein_eaten
 * @property float $fat_eaten
 * @property float $carbohydrates_eaten
 * @property float $fiber_eaten
 * @property integer $weight_eaten
 * @property integer $calories_eaten
 * @property string $user_id
 * @property string|Carbon $created_at
 * @property string|Carbon $updated_at
 * @property Portion[] $portions
 */
class Day extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->timestamps = true;
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
            'calories',
            'protein_eaten',
            'fat_eaten',
            'carbohydrates_eaten',
            'fiber_eaten',
            'weight_eaten',
            'calories_eaten',
            'user_id',
        ];
        $this->dates = ['date'];
        parent::__construct($attributes);
    }

    /**
     * @return HasMany
     */
    public function portions(): HasMany
    {
        return $this->hasMany(Portion::class);
    }


    /**
     * @return bool
     */
    public function isEaten(): bool
    {
        foreach ($this->portions as $portion) {
            if (!$portion->eaten) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get PFC ratio for day.
     *
     * @return array
     */
    public function getRatio(): array
    {
        if ($this->calories === 0) {
            return [0, 0, 0];
        }
        $proteinCalories = $this->protein * 4;
        $fatCalories = $this->fat * 8;
        $carbohydratesCalories = $this->carbohydrates * 4;

        $percent = $this->calories / 100;

        return [
            (int)ceil($proteinCalories / $percent),
            (int)ceil($fatCalories / $percent),
            (int)ceil($carbohydratesCalories / $percent)
        ];
    }

    /**
     * @return array
     */
    public function getProgress(): array
    {
        if ((int)$this->calories === 0) {
            return [0, 0, 0];
        }
        $result = [];
        if ((int)$this->protein === 0) {
            $result[] = 0;
        } else {
            $result[] = (int)ceil($this->protein_eaten / ($this->protein / 100));
        }
        if ((int)$this->fat === 0) {
            $result[] = 0;
        } else {
            $result[] = (int)ceil($this->fat_eaten / ($this->fat / 100));
        }
        if ((int)$this->carbohydrates === 0) {
            $result[] = 0;
        } else {
            $result[] = (int)ceil($this->carbohydrates_eaten / ($this->carbohydrates / 100));
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return "{$this->date->day} {$this->date->localeMonth} {$this->date->year}";
    }
}